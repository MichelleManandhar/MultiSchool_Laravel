<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;

class ExamDetailController extends Controller
{
    public function insertFullAndPassMarks(Request $request){

    }

    public function checkExam($examId){
        try{
            $examExists = Exam::findOrFail($examId);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
