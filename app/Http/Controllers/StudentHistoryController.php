<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\ClassDetail;
use App\Section;
use App\Student;
use App\Exam;
use App\StudentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentHistoryController extends Controller
{
    //
    public function studentHistoryEvent(Request $request, Student $student){
        try{
            $studentStoreToHistory = new StudentHistory();
            $studentStoreToHistory->student_id = $student->id;
            $studentClass = DB::table('classes')
            ->join('students','classes.id', '=', 'students.class_id')->select('name')
            ->where('students.id', $student->id) ->get();
            $className = $studentClass[0]->name;
            $studentClassId = DB::table('classes')
            ->join('students','classes.id', '=', 'students.class_id')->select('class_id')
            ->where('students.id', $student->id) ->get();
            $classId = $studentClassId[0]->class_id;
            $promoteClassId = $classId + 1;
            $demoteClassId = $classId - 1;
            $studentSection = DB::table('sections')
            ->join('students', 'sections.id', '=', 'students.section_id')->select('name')
            ->where('students.id',$student->id)->get();
            $sectionName = $studentSection[0]->name;
            $message= $request->get('event');
            if ($message == 'Leave'){
                $studentStoreToHistory->action = "Left school at class ".$className.".";
            }
            elseif ($message == 'Demote'){
                $studentDemotedClass = DB::table('classes')
                    ->select('name')->where('id',$demoteClassId)->get();
                $demotedClassName = $studentDemotedClass[0]->name;
                $studentStoreToHistory->action = "Demoted from class ".$className." ,section ".$sectionName." to class ".$demotedClassName.".";
            }
            elseif ($message == 'Promote'){
                $studentPromotedClass = DB::table('classes')
                    ->select('name')->where('id',$promoteClassId)->get();
                $promotedClassName = $studentPromotedClass[0]->name;
                $studentStoreToHistory->action = "Promoted from class ".$className." ,section ".$sectionName." to class ".$promotedClassName.".";
            }
            elseif ($message == 'StudentUpdated'){
                $studentStoreToHistory->action= "Student information updated.";
            }
            elseif ($message == 'StudentAdded'){
                $studentStoreToHistory->action= "Student registered.";
            }
            else{
                $studentStoreToHistory->action= "Student deleted.";
            }
            $res = $studentStoreToHistory->save();
            if($res){
                return response()->json([
                    'status' => 1,
                    'data' => $studentStoreToHistory
                ]);
            }
        }
        catch (Exception $e) {
        throw $e;
        }
    }

    public function examHistoryEvent(Request $request, Student $student, Exam $exam){
        try{

            $examStoreToHistory= new StudentHistory();
            $examStoreToHistory->student_id = $student->id;

            $examDetail= Exam::where('id',$exam->id)->get('name');
            $examName = $examDetail[0]->name;

            $studentClass = DB::table('classes')
                ->join('students', 'classes.id', '=', 'students.class_id')
                ->select('name')
                ->where('students.id', $student->id)
                ->get();
                $class = $studentClass[0]->name;

            $studentSection = DB::table('sections')
                ->join('students', 'sections.id', '=', 'students.section_id')
                ->select('name')
                ->where('students.id', $student->id)
                ->get();
                $section = $studentSection[0]->name;

            $message = $request->get('event');
            if ($message == 'ExamDetail'){
                $examStoreToHistory->action = $examName." result of class ".$class." section ".$section. " is printed.";
                }
            $res = $examStoreToHistory->save();

                if($res){
                    return response()->json([
                        'status' => 1,
                        'data' => $examStoreToHistory
                    ]);
                }
            }
            catch (Exception $e) {
                throw $e;
                }
     }
}
