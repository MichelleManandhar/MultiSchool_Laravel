<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionTeacherResource;
use App\SectionTeacher;
use Illuminate\Http\Request;

class SectionTeacherController extends Controller
{
    public function index(Request $request ,  $section_id){
        try{
            $section_teacher = SectionTeacher::where('section_id','=',$section_id)->get();
            return response()->json(
                [
                    'status' => 'success',
                    'teacher_data' => SectionTeacherResource::collection($section_teacher)
                ], 200);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
