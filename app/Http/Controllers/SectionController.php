<?php

namespace App\Http\Controllers;

use App\ClassDetail;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function getStudentOnBasisOfSection(){

    }

    public function addSection(Request $request,ClassDetail $class){
        try{
            DB::beginTransaction();
            $classId = $this->getStoredSectionId($request->get('name'));
            $class->section()->sync([$classId]);
            return response()->json([
                'status' => 1,
                'message' => 'Section stored'
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function index(ClassDetail $class){
        try{
            return $class->section()->where('delete_flag',0)->get();
            } catch (Exception $e) {
                throw $e;
            }
    }

    public function store(Request $request,ClassDetail $class){
        try {
            $validate = $request->validate([
                'name' => 'required'
            ]);
            $section = new Section();
            $name = mb_strtoupper($request->get('name'));
            $section->name = $name;
            $section->class_id = $class->id;
            $section->save();
            return response()->json([
                'status' => 1,
                'section_data' => $section
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function update(Request $request, ClassDetail $class, Section $section){
        try{
            $validate = $request->validate([
                'name' => 'required'
            ]);
            $section->name = $request->get('name');
            $section->save();
            return response()->json([
                'status' => 1,
                'message' => 'Update Successfully'
            ]);
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function destroy(Request $request, ClassDetail $class){
        try{
            foreach ($request->get('sections') as $section){
                $result = Section::where('id',$section['id'])->update([
                    'delete_flag' => 1
                ]);
            }
        }catch(\Exception $e){
            throw $e;
        }
    }
}
