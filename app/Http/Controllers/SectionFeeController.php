<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionFeeController extends Controller
{
    public function index($section_id)
    {
        $section_subject = SectionSubject::where('section_id', '=', $section_id)->where('delete_flag','=',0)->get();

        return response()->json(
            [
                'status' => 'success',
                'subject_data' => SectionSubjectResource::collection($section_subject)
            ], 200);
    }

    public function store(Request $request, Section $section)
    {
//        dd('H');
        try {
            $sectionSubject = new SectionSubject();
            $sectionSubject = $this->storeOrUpdateFunction($request, $section->id, $sectionSubject);
            return response()->json([
                'status' => 1,
                'subject_data' => new SectionSubjectResource($sectionSubject)
            ]);
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function storeOrUpdateFunction(Request $request, $sectionId, SectionSubject $sectionSubject)
    {
        try {
            $subjectExist = Subject::findOrFail($request->get('subject_id'));
            $sectionSubject->subject_id = $subjectExist->id;
            $teacherExist = Teacher::findOrFail($request->get('teacher_id'));
            $sectionSubject->teacher_id = $teacherExist->id;
            $sectionSubject->subject_code = $request->get('subject_code');
            $sectionSubject->section_id = $sectionId;
            $sectionSubject->save();
            return $sectionSubject;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, Section $section, SectionSubject $sectionSubject)
    {
//        $sectionSubject = new SectionSubject();
        $sectionSubject = $this->storeOrUpdateFunction($request, $section->id, $sectionSubject);
        return response()->json([
            'status' => 1,
            'subject_data' => new SectionSubjectResource($sectionSubject)
        ]);
    }

    public function deleteSubject(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->get('subjects') as $subject) {
                $subjectToStore = SectionSubject::find($subject['id']);
                $subjectToStore->delete_flag = 1;
                $subjectToStore->save();

                $result =  Mark::where('section_id', $subjectToStore->section_id)
                    ->where('subject_id', $subjectToStore->subject_id)
                    ->update(['delete_flag' => 1]);

                $nextExamMarkDeleteResult = ExamSubject::where('section_id', $subjectToStore->section_id)
                    ->where('subject_id', $subjectToStore->subject_id)
                    ->update(['delete_flag' => 1]);

            }
            DB::commit();
            return response()->json([
                'status' => 1,
                'data' => 'successfull'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
