<?php

namespace App\Http\Controllers;

use App\ClassDetail;
use App\Exam;
use App\Http\Resources\SubjectResource;
use App\SchoolUser;
use App\Section;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index( Request $request){
        try{
            $getAllSubject = Subject::where('school_id' , $request->user()->school()->first()->id)->where('delete_flag',0)->get();
            return response()->json([
                'status' => 1,
                'subjects' => $getAllSubject
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllSubjects(){
        try{
            $allSubject = Subject::all();
            return response()->json([
                'status' => 1,
                'subject' => $allSubject
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request ){
        try{
            $subject = new Subject();
            $subject = $this->fillSubject($request,$subject);
            $subject->school_id = $request->user()->school()->first()->id;
            $subject->save();
            return response()->json([
                'status' => 1,
                'subject' => $subject
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, Subject $subject){
        try{
            $subject = $this->fillSubject($request,$subject);
            return response()->json([
                'status' => 1,
                'subject' => $subject
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function fillSubject(Request $request,Subject $subject){
        try{
            $this->validate($request,[
                'name'=>'string|required'
             ]);
            $subject->name = $request->get('name');
            $subject->save();
            return $subject;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeSubjectForClass(Request $request,$classId){
        try{
            $this->validate($request,[
                'name'=>'string|required'
             ]);
            DB::beginTransaction();
            $subjectToStore = new Subject();
            $subjectToStore->name = $request->get('name');
            $subjectToStore->save();
            $subjectToStore->class()->sync([$classId]);
            DB::commit();
            return response()->json([
                'status' => 1,
                'data' => 'successfully stored data'
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getSubjectWithRespectToClass($classId){
        try{
            $class = ClassDetail::find($classId);
            $subjects = $class->subject;
            return response()->json([
                'status' => 1,
                'data' => $subjects
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addSubjectForSection(Request $request,ClassDetail $class, Section $section){

    }

    public function deleteSubject(Request $request){
        try{
            DB::beginTransaction();
            DB::commit();
        }catch(\Exception $exception){
            return $exception;
        }
    }
    public function remove(Request $request , $sub){
        try{
            $subject = Subject::findorfail($sub);
            $subject->delete_flag = 1;
            $subject->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted'
            ]);
        }
        catch(Exception $e){
            throw $e;
        }
    }


    public function getSubjectId($id){
        try{
            $subject = Subject::findorfail($id);
            return $subject->id;
        } catch (Exception $e) {
            throw $e;
        }
        }

    public function editSubjectForSection(Request $request,ClassDetail $class, Section $section){

    }
}
