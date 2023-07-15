<?php

namespace App\Http\Controllers;

use App\ExamSubject;
use App\Http\Resources\MarkResource;
use App\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MarkRequest;
use App\ClassDetail;
use App\Section;
use App\Exam;
use App\Subject;
use App\Student;
use function Opis\Closure\serialize;
use App\SectionSubject;

class MarkController extends Controller
{
    private $totalObtainedMark, $totalObtainedGrade, $totalWholeSubjectsMarks;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $section_id = $request->section_id;
            $student_ids= $request->student_ids;
            $section = Section::with(['student' => function ($query) {
                $query->with(['marks' => function ($q) {
                    $q->select(['marks.id', 'student_id', 'subject_id', 'subjects.name as subject', 'theoritical', 'practical'])
                        ->join('subjects', 'subjects.id', '=', 'marks.subject_id');
                }])
                    ->where('delete_flag', 0);

            }])->join('classes', 'classes.id', '=', 'sections.class_id')
                ->select(['sections.id', 'sections.name as section', 'classes.name as class', 'class_id'])
                ->find($request->section_id);
            $marks = Exam::join('marks', 'exams.id', '=', 'marks.exam_id')
                ->join('sections', 'sections.id', '=', 'marks.section_id')
                ->select(['exams.name as examination_name',

                    'sections.name as section'
                ])
                ->distinct()
                ->where('marks.exam_id', '=', $request->exam_id)
                ->where('marks.section_id', '=', $request->section_id)
                ->first();
            $exam_id = $request->exam_id;
            $students = Student::with(['marks' => function ($query) use ($section_id, $exam_id) {
                $query->select(['student_id',
                    'marks.practical_grade as gpa_pr',
                    'marks.theory_grade as gpa_th',
                    'marks.full_grade as gpa_total',
                    'marks.full_gpa as gpa',
                    'subjects.name'
                ])
                    ->join('subjects', 'subjects.id', '=', 'marks.subject_id')->where('marks.delete_flag', 0)
                    ->whereNotNull('marks.theoritical')
                    ->whereNotNull('marks.practical')
                ->where('marks.exam_id',$exam_id)
                ->where('marks.section_id',$section_id);
                return $query;
            }])

                ->with(['attendance' => function ($query) {
                    $query->select([
                        'student_id',
                        'present_days',
                        'school_days'
                    ]);
                }])
                ->select(['id', 'roll_no'])->selectRaw("CONCAT(IFNULL(fname,''),' ',IFNULL(mname,''),' ',IFNULL(lname,'')) as name")->where('section_id', '=', $section_id)->where('delete_flag', 0)->
                when($student_ids, function($query,$student_ids){
                    return $query->whereIn('id',$student_ids);
                })->orderBy('roll_no', 'ASC')->get();
                
            $data = new \stdClass();
            $data->examination_name = $marks->examination_name;
            $data->examination_year = '2076';
            $data->school_name = "Bhassara Secondary School";
            $data->class = $section->class;
            $data->section = $section->section;
            $data->exam_details = $students;

            return response()->json($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarkRequest $request)
    {
        $entered = [];
        try {
            $validated = $request->validated();
            $sectionId = trim($request->get('section'));
            $examId = trim($request->get('exam'));
            $examDetails = $request->get('exam_details');
            foreach ($examDetails as $key => $val) {
                $studentId = $val['student_id'];
                $student = Student::find($studentId);
                if (array_key_exists('marks', $val)) {
                    foreach ($val['marks'] as $k => $mark) {
                        $subjectId = $mark['subject'];
                        $markId = Mark::where('subject_id', '=', $subjectId)->where('student_id', '=', $studentId)->where('exam_id', '=', $examId)->where('delete_flag', 0)->first();
                        $entryMark = null;
                        if ($markId) {
                            $entryMark = $markId;
                        } else {
                            $entryMark = new Mark();
                        }
                        $examMark = ExamSubject::where('subject_id', '=', $subjectId)->where('section_id', '=', $sectionId)->where('exam_id', '=', $examId)->first();
                        if(!$examMark ){
                            throw new \Exception('please enter the full marks first',10000);
                        }
                        $entryMark->student_id = $studentId;
                        $entryMark->section_id = $sectionId;
                        $entryMark->exam_id = $examId;
                        $entryMark->subject_id = $subjectId;
                        $entryMark->theoritical = $mark['theory'];
                        $entryMark->practical = $mark['practical'];

                        $fullMarks = $examMark->theory_full + $examMark->practical_full;
                         if ($examMark->practical_full != 0 && $mark['practical']) {
                             $practicalPercentage = $this->getPercentage($examMark->practical_full, $mark['practical']);
                             $entryMark->practical_grade = $this->getGrade($practicalPercentage);
                         }
                         else{
                             $entryMark->practical_grade = null;
                         }
                         if ($examMark->theory_full != 0 && $mark['theory']) {
                             $theoriticalPercentage = $this->getPercentage($examMark->theory_full, $mark['theory']);
                             $entryMark->theory_grade = $this->getGrade($theoriticalPercentage);
                         }
                         else{
                             $examMark->theory_full = null;
                         }
                        $fullObtainedMarks = $mark['theory'] + $mark['practical'];
                        $full_percentage = $this->getPercentage($fullMarks, $fullObtainedMarks);
                        $entryMark->full_percentage = $full_percentage;
                        $entryMark->full_grade = $this->getGrade($full_percentage);
                        $entryMark->full_gpa = $this->getGpa($full_percentage);
                        $entryMark->save();
                        $entered[] = $entryMark;
                    }
                }
            }
            return $entered;
            
        }catch (Exception $e) {
            throw $e;
        }
    }

    public function show(Mark $mark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mark $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        //
    }


    public function markSheet(Request $request)
    {
        try {
            $v = Validator::make($request->all(), [
                'section' => 'required',
            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }
            $student = [];
            if ($request->get('student')) {
                $student->with('marks')->where('id', '=', $request->get('student'))->get();
            } else {
                $student->with('marks')->where('section_id', '=', $request->get('section'))->get();
            }
            return $student;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMarksStudent(Section $section, $exam,$rankcal = null)
    {
        try {
            $mainCollection = [];
            $students = $section->student()->where('delete_flag', '=', 0)->orderBy('roll_no')->get();
            $flag = 0;
            foreach ($students as $student) {
                $examObj = Exam::find($exam);
                $markToOperate = $student->marks()->where('delete_flag', 0)->where('exam_id', '=', $examObj->id)->get();
         
                $mark = isset($markToOperate) && $examObj != '' ? MarkResource::collection($markToOperate) : null;
                $markcollection = collect($mark)->collapse();
                $markToOperate = collect($markToOperate);
                $countMarks = ExamSubject::where('section_id', '=', $section->id)->where('exam_id', '=', $exam)->count();
                if ($markToOperate->count() > 0 && $rankcal != null && $countMarks>0) {
                    $flag = 1;
                    $fullObtainedMarks = $markToOperate->sum('theoritical') + $markToOperate->sum('practical');
                    $examMark = collect(ExamSubject::where('section_id', '=', $section->id)->where('exam_id', '=', $exam)->where('delete_flag',0)->get());
                    $getFullSubjectMarks = $examMark->sum('theory_full') + $examMark->sum('practical_full');
                    $fullPercentage = $this->getPercentage($getFullSubjectMarks, $fullObtainedMarks);
                    $fullGrade = $this->getGrade($fullPercentage);
                    $fullGPA = round($markToOperate->sum('full_gpa') / $markToOperate->count(),2);
                }
                $merge = $markcollection->merge([
                    'student_id' => $student->id,
                    'roll_no' => $student->roll_no,
                    'name' => ($student->mname != '') ? $student->fname . ' ' . $student->mname . ' ' . $student->lname : $student->fname . ' ' . $student->lname,
                ]);
                if ($flag) {
                    $merge = $merge->merge([
                        'full_grade' => isset($fullGrade) ? $fullGrade : null,
                        'full_pa' => isset($fullGPA) ? $fullGPA : null,
                        'full_obtained' => isset($fullObtainedMarks) ? $fullObtainedMarks : null,
                        'full_percentage' => isset($fullPercentage) ? $fullPercentage : null
                    ]);
                }
                array_push($mainCollection, $merge);
            }
            if ($flag) {
                $mainCollection = collect($mainCollection)->sortByDesc('full_obtained')->values()->values();
                for ($i = 0; $i < count($mainCollection); $i++) {
                    $mainCollection[$i] = $mainCollection[$i]->merge(['roll_computed' => $i + 1]);
                }
            }
            return collect($mainCollection)->sortBy('roll_no')->values();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function getPercentage(int $total, int $obtained)
    {
        try{
            if ((int)$obtained == 0) {
                return 0;
            }
            $percentage = round(($obtained / $total * 100), 2);
            return $percentage;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getFullMarks($examId, $studentId, $sectionId)
    {
        try{
             $marks = Mark::where('exam_id', $examId)->where('student_id')->where('sectionId');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getGrade($percentage)
    {
        try{
            switch ($percentage) {
                case $percentage <= 19.99 && $percentage >= 0.10:
                    return 'E';
                case $percentage <= 29.99 && $percentage >= 20:
                    return 'D';
                case $percentage <= 39.99 && $percentage >= 30:
                    return 'D+';
                case $percentage <= 49.99 && $percentage >= 40:
                    return 'C';
                case $percentage <= 59.99 && $percentage >= 50:
                    return 'C+';
                case $percentage <= 69.99 && $percentage >= 60:
                    return 'B';
                case $percentage <= 79.99 && $percentage >= 70:
                    return 'B+';
                case $percentage <= 89.99 && $percentage >= 80:
                    return 'A';
                case $percentage <= 100 && $percentage >= 90:
                    return 'A+';
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getGpa($percentage)
    {
        try{
            switch ($percentage) {
                case $percentage <= 19.99 && $percentage >= 0.10:
                    return 0.80;
                case $percentage <= 29.99 && $percentage >= 20:
                    return 1.20;
                case $percentage <= 39.99 && $percentage >= 30:
                    return 1.60;
                case $percentage <= 49.99 && $percentage >= 40:
                    return 2.00;
                case $percentage <= 59.99 && $percentage >= 50:
                    return 2.40;
                case $percentage <= 69.99 && $percentage >= 60:
                    return 2.80;
                case $percentage <= 79.99 && $percentage >= 70:
                    return 3.20;
                case $percentage <= 89.99 && $percentage >= 80:
                    return 3.60;
                case $percentage <= 100 && $percentage >= 90:
                    return 4.00;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getStructureData(Exam $exam, Section $section)
    {
        try{
            $student = $section->student[0];
            $student = new \stdClass();
            $markSheet = [
                'examination_name' => $exam->name,
                'examination_year' => '2076',
                'school_name' => "Bhassara School",
                'class' => $section->classDetail->name,
                'section' => $section->name,
            ];
            dd($markSheet);
        } catch (Exception $e) {
        throw $e;
        }
    }

    public function storeOrEditMarks(){

    }

    public function createOrUpdateFullMarks(Request $request,Section $section, Exam $exam){
        try {
            $subjects = SectionSubject::where('section_id',$section->id)->where('delete_flag',0)->with('subject')->get();
            foreach($subjects as $key => $subject){
                        $subjectId = $subject->subject_id;
                        $examMark = ExamSubject::where('subject_id', '=', $subjectId)->where('section_id', '=', $section->id)->where('exam_id', '=', $exam->id)->first();
                        if ($examMark == '') {
                            $examMark = new ExamSubject();
                        }
                        $examMark->section_id = $section->id;
                        $examMark->exam_id = $exam->id;
                        $examMark->subject_id = $subjectId;
                        $examMark->theory_full = $request->has(strtolower($subject->subject['name']).'-theory')?$request->get(strtolower($subject->subject['name']).'-theory'):0;
                        $examMark->practical_full =  $request->has(strtolower($subject->subject['name']).'-practical')?$request->get(strtolower($subject->subject['name']).'-practical'):0;
                        $examMark->save();
                    }
            return response()->json([
                'status' => 1,
                'message' => 'successfully stored'
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function getSubjectPracticalAndTheoryMarks(Section $section,Exam $exam){
        try{
            $subjects = $section->subject;
            $fullmarks =[];
            foreach($subjects as $subject){
                $subjectmarks = $subject->subject_marks()->select('practical_full','theory_full')->where('section_id',$section->id)->where('exam_id',$exam->id)->where('delete_flag',0)->first();
                $fullmarks[strtolower($subject->name).'-theory'] = isset($subjectmarks->theory_full)?$subjectmarks->theory_full:null;
                $fullmarks[strtolower($subject->name).'-practical'] = isset($subjectmarks->practical_full)?$subjectmarks->practical_full:null;
            }
            return $fullmarks;
        }
        catch(\Exception $e){
            throw $e;
        }
    }

}
