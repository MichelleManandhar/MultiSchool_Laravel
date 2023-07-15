<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\ClassDetail;
use App\Fee;
use App\FeeBill;
use App\FeeCategory;
use App\FeeDetail;
use App\Section;
use App\SectionFee;
use App\Student;
use Carbon\Carbon;
use App\Sponsor;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\StudentSponsorResource;

class StudentController extends Controller
{
    public function index()
    {

    }

    public function getStudentOfClass($classId)
    {
        try{
            $students = ClassDetail::find($classId);
            return response()->json([
                'status' => 1,
                'data' => $students
            ]);
        } catch (Exception $e) {
        throw $e;
    }
    }

    public function addStudentForSection(Request $request, ClassDetail $class, Section $section)
    {
        try{
            DB::beginTransaction();
            $studentToStore = new Student();
            $studentToStore->class_id = $class->id;
            $studentToStore->section_id = $section->id;
            $studentToStore = $this->storeOrEditStudent($request, $studentToStore);
            $this->addToAttendance($studentToStore->id, $section->id);
            $this->createBillForStudent($studentToStore);
            DB::commit();
            return response()->json([
                'status' => 1,
                'data' => $studentToStore
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addToAttendance($studentId, $sectionId)
    {
        try {
            $attendance = new Attendance();
            $attendance->student_id = $studentId;
            $attendance->section_id = $sectionId;
            $attendance->save();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function editStudentForSection(Request $request, ClassDetail $class, Section $section, Student $student)
    {
        try{
            // dd($request);
            $studentStored = $this->storeOrEditStudent($request, $student);
            return response()->json([
                'status' => 1,
                'message' => 'Student Updated'
            ]);
    } catch (Exception $e) {
        throw $e;
    }
    }

    public function storeOrEditStudent(Request $request, Student $studentToStore)
    {
        try{
            $this->validate($request,[
               'roll_no'=>'required',
               'fname'=>'required|string',
               'lname'=>'required|string',
               'DOB'=>'required',
               'mname'=>'string|nullable',
               'mobile_no'=>'digits_between:9,10|nullable',
               'fathers_name'=>'string|nullable',
               'fathers_contact'=>'digits_between:9,10|nullable',
               'mothers_name'=>'string|nullable',
               'mothers_contact'=>'digits_between:9,10|nullable',
               'permanent_address'=>'string|nullable',
               'temporary_address'=>'string|nullable',
               'parent_name'=>'string|nullable'
            ]);

            $studentToStore->fname = $request->get('fname');
            $studentToStore->lname = $request->get('lname');
            $studentToStore->mname = $request->get('mname');
            $studentToStore->DOB = $request->get('DOB');
            $studentToStore->mobile_no = $request->get('mobile_no');
            $studentToStore->fathers_name = $request->get('fathers_name');
            $studentToStore->fathers_contact = $request->get('fathers_contact');
            $studentToStore->mothers_name = $request->get('mothers_name');
            $studentToStore->mothers_contact = $request->get('mothers_contact');
            $studentToStore->permanent_address = $request->get('permanent_address');
            $studentToStore->temporary_address = $request->get('temporary_address');
            $studentToStore->parent_name = $request->get('parent_name');
            $studentToStore->roll_no = $request->get('roll_no');
            $sponsorExists = Sponsor::findOrFail($request->get('sponsor_id'));
            $studentToStore->sponsor_id = $sponsorExists->id;
            $image = $request->file('image');
            $folder_path =  storage_path() . DIRECTORY_SEPARATOR . 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
            if( $request->file('image')){
                $file = $request->file('image');
                    $original_file_name = $file->getClientOriginalName() ?: null;
                    $original_file_name_extension = $file->getClientOriginalExtension() ?: null;
                    $file_name = rand(1, 99999) . strtotime("now") . '_' . $original_file_name;
                    $file->move($folder_path, $file_name);
                $studentToStore->image_name = $file_name;
            }
            $studentToStore->save();
            return $studentToStore;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getStudentsOfSection(Section $section)
    {
        try{
            $students = $section->student()->where('delete_flag', '=', 0)->orderBy('roll_no')->get();
            return response()->json([
                'status' => 1,
                'data' => StudentSponsorResource::collection($students)
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMarksForStudent($id)
    {
        try{
        $student = Student::find($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createBillForStudent(Student $student){
        try{
        $sum = 0 ;
        $now = Carbon::now();
        $feeBill = new FeeBill();
        $feeBill->student_id = $student->id;
        $feeBill->year = $now->year;
        $feeBill->month = $now->month;
        $feeBill->save();
        $feeCategories = FeeCategory::all();
        foreach ($feeCategories as $cat){
            $sectionFee =  SectionFee::where('section_id' ,$student->section_id )->where('fee_category_id' , $cat->id)->first();
            $fees = Fee::where('student_id' , $student->id)->where('fee_category_id' , $cat->id)->first();
            if($fees != null){
                $fees->fee_bill_id = $feeBill->id;
                $fees->save();
            }
            else{
                $fee = new Fee();
                $fee->section_id  = $student->section_id;
                $fee->student_id  = $student->id;
                $fee->fee_category_id  = $cat->id;
                $fee->fee_bill_id  = $feeBill->id;
                $fee->amount   =isset($sectionFee) ? $sectionFee->amount : 0 ;
                $sum = $sum + $fee->amount ;
                $fee->save();
            }
        }
        $feeDetail = FeeDetail::where('student_id' , $student->id)->first();
        if($feeDetail != null){
            $feeDetail->fee_bill_id = $feeBill->id;
            $feeDetail->total = $sum;
            $feeDetail->save();
        }
        else{
            $feeDetail = new FeeDetail();
            $feeDetail->section_id  = $student->section_id;
            $feeDetail->student_id  = $student->id;
            $feeDetail->fee_bill_id  = $feeBill->id;
            $feeDetail->total = $sum ;
            $feeDetail->save();
        }} catch (\Exception $e) {
            throw $e;
        }
    }


    public function deleteStudent(Request $request)
    {
        try {
            $students = $request->get('students');
            foreach ($students as $student) {
                $studentToDelete = Student::find($student['id']);
                $studentToDelete->delete_flag = 1;
                $studentToDelete->save();

                $studentToDelete->attendance->delete_flag=1;
                $res = $studentToDelete->attendance->save();
                if($res){
                    return response()->json([
                        'status' => 1,
                        'message' => 'Student removed  '
                    ]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function leaveStudent(Request $request , $student){
        try{
            $studentToDelete = Student::find($student);
            $studentToDelete->delete_flag = 1;
            $studentToDelete->save();
            $studentToDelete->attendance->delete_flag=1;
            $res = $studentToDelete->attendance->save();
            if($res){
                return response()->json([
                    'status' => 1,
                    'message' => 'Student removed'
                ]);
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function demoteStudent(Request $request , $student)
    {
        try {
            $studentToDemote = Student::find($student);
            $studentToDemote->class_id = $studentToDemote->class_id - 1 ;
            $section = Section::where('class_id' , $studentToDemote->class_id )->get();
            $class = ClassDetail::where('id' , $studentToDemote->class_id)->get();
            $studentToDemote->section_id =$section[count($section)-1]->id;
            $res = $studentToDemote->save();
            if($res){
                return response()->json([
                    'status' => 1,
                    'message' => 'Student demoted to '.$class[0]->name
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }

    }
    public function promoteStudent(Request $request , $student)
    {
        try {
            $studentToPromote = Student::find($student);
            $studentToPromote->class_id = $studentToPromote->class_id + 1 ;
            $section = Section::where('class_id' , $studentToPromote->class_id )->get();
            $studentToPromote->section_id =$section[count($section)-1]->id;
            $class = ClassDetail::where('id' , $studentToPromote->class_id)->get();
            $res = $studentToPromote->save();
            if($res){
                return response()->json([
                    'status' => 1,
                    'message' => 'Student Promoted to '.$class[0]->name
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }

}
}
