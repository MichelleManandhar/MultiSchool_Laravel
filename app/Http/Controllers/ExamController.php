<?php

namespace App\Http\Controllers;

use App\Exam;
use App\SchoolUser;
use Illuminate\Http\Request;
use Exception;

class ExamController extends Controller
{
    public function index( Request $request)
    {
        try{    
         $allExams = Exam::where('school_id' ,$request->user()->school()->first()->id)->where('delete_flag',0)->get();
        return response()->json([
            'status' => 1,
            'exams' => $allExams
        ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request)
    {
        try {
                $this->validate($request,[
                'name'=>'required',

            ]);
            $examToStore = new Exam();
            $examToStore = $this->storeOrUpdateExam($request, $examToStore);
            $examToStore->school_id = $request->user()->school()->first()->id;
            $examToStore->save();
            return response()->json(
                [
                    'status'=>1,
                    'exam'=>$examToStore
                ]
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeOrUpdateExam(Request $request, Exam $exam)
    {
        try {
            $this->validate($request,[
                'name'=>'required'
            ]);
            $exam ->name= $request->get('name');
            $exam->save();
            return $exam;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, Exam $exam)
    {
        try {
            $exam = $this->storeOrUpdateExam($request, $exam);
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function destroy(Request $request,Exam $exam){
        try{
            $exam->delete_flag = 1;
            $exam->save();
            return response()->json([
                'status' => 1,
                'exam' => $exam
            ]);
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function remove(Request $request, $em){
        try{
            $exam = Exam::findOrfail($em);
            $exam->delete_flag = 1;
            $exam->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted'
            ]);
            }
        catch(Exception $e){
            throw $e;
        }
    }
}
