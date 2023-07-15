<?php

namespace App\Http\Controllers;

use App\SchoolUser;
use App\Teacher;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Section;
use App\SectionSubject;

class TeacherController extends Controller
{
    public function index( Request $request ){
    try{
        $teacher = Teacher::where('school_id' ,  $request->user()->school()->first()->id)->where('delete_flag',0)->get();

        return response()->json([
            'status' => 1,
            'teacher' => $teacher
        ]);
    } catch (Exception $e) {
        throw $e;
    }
    }

    public function store(Request $request){
        try{
            $teacher = new Teacher();
            $teacher = $this->storeOrUpdateTeacher($request,$teacher);
            $teacher->school_id = $request->user()->school()->first()->id;
            $teacher->save();
            return response()->json([
                'status' => 1,
                'teacher' => $teacher
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeOrUpdateTeacher(Request $request,Teacher $teacher){
        try{
            $this->validate($request,[
                'name'=>'string|required',
                'designation'=>'string|required',
                'contact_no'=>'digits_between:9,10',
                'address'=>'string',
                'DOB'=>'required'
             ]);
            $teacher->name = $request->get('name');
            $teacher->designation = $request->get('designation');
            $teacher->contact_no = $request->get('contact_no');
            $teacher->address = $request->get('address');
            $teacher->DOB = $request->get('DOB');
            $folder_path =  storage_path() . DIRECTORY_SEPARATOR . 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
            if($request->file('image')){
                $file = $request->file('image');
                $original_file_name = $file->getClientOriginalName() ?: null;
                $original_file_name_extension = $file->getClientOriginalExtension() ?: null;
                $file_name = rand(1, 99999) . strtotime("now") . '_' . $original_file_name;
                $file->move($folder_path, $file_name);
                $teacher->image_name = $file_name;
            }
            $teacher->save();
            return $teacher;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request,Teacher $teacher){
        try{
            return response()->json([
                'status' => 1,
                'teacher' => $this->storeOrUpdateTeacher($request,$teacher)
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function remove(Request $request,  $t){
        try{
            $teacher = Teacher::findOrfail($t);
            $teacher->delete_flag = 1;
            $teacher->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted'
            ]);
        }catch(Exception $e){
            throw $e;
        }

    }
    public function getTeacherForSection(Section $section){
        try{
            $teacher = SectionSubject::select('teachers.id','teachers.name as teacher','subjects.name as subject','teachers.designation')->join('teachers','teachers.id','section_subject.teacher_id')
            ->join('subjects','subjects.id','section_subject.subject_id')
            ->where('section_subject.section_id',$section->id)->get();
            return response()->json([
                'status' => 1,
                'data' => $teacher
            ]);
        }catch (Exception $e) {
            throw $e;
        }
    }
}