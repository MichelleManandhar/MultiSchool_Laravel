<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Resources\AttendanceResource;
use App\Section;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{   
    public function getStudentOfSection(Section $section)
    {
        try{
            $students = $section->student()->where('delete_flag','=',0)->get();
            return response()->json([
                'status' => 1,
                'students' => $students
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function index(Section $section)
    {
        try{
            $attendance = $section->attendance()->where('delete_flag','=',0)->get();
            return response()->json([
                'status' => 1,
                'attendance' => AttendanceResource::collection($attendance)
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request, Section $section)
    {
        try{
            $this->validate($request,[
                'present_days'=>'required|integer'
            ]);
            $attendanceToStore = new Attendance();
            $attendanceToStore = $this->storeOrUpdateAttendance($request, $section, $attendanceToStore);
            return response()->json([
                'status' => 1,
                'attendance' => $attendanceToStore
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeOrUpdateAttendance(Request $request, Section $section, Attendance $attendanceToStore)
    {
        try{
            $this->validate($request,[
                'present_days'=>'required|integer'
            ]);
            $attendanceToStore->section_id = $section->id;
            $attendanceToStore->student_id = $request->get('student_id');
            $attendanceToStore->school_days = $request->get('school_days');
            $attendanceToStore->present_days = $request->get('present_days');
            $attendanceToStore->save();
            return $attendanceToStore;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, Section $section, Attendance $attendance)
    {
        try{
            $this->validate($request,[
                'present_days'=>'required|integer'
            ]);          
            $attendance = $this->storeOrUpdateAttendance($request, $section, $attendance);
            return response()->json([
                'status' => 1,
                'attendance' => $attendance
            ]);
        } catch (Exception $e) {
            throw $e;
        }
}
}