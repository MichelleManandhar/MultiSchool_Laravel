<?php

namespace App\Http\Controllers;

use App\ClassDetail;
use App\Http\Resources\ClassDetailResource;
use App\SchoolUser;
use Illuminate\Http\Request;

class ClassDetailController extends Controller
{
    public function index()
    {
        try{
            $classes = ClassDetail::all();
            return response()->json(
                [
                    'status' => 'success',
                    'classes' => ClassDetailResource::collection($classes)
                ], 200);
        } catch (Exception $e) {
            throw $e;
        }
        }

    public function getAllClasses(Request $request ){
        try{
            $school_id = $request->user()->school()->first()->id;
            $classes = ClassDetail::where('school_id' ,$school_id)->where('delete_flag', 0)->get();
            return response()->json(
                [
                    'status'=>'success',
                    'classes' => ClassDetailResource::collection($classes)
                ]
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, $class){
        try{
            $class = ClassDetail::find($class);
            $class->name = $request->get('name');
            $class->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully updated'
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function store(Request $request){
        try{
            $this->validate($request,[
                'name'=>'required|integer'
            ]);
            $school_id = $request->user()->school()->first()->id;
            $class = new ClassDetail();
            $class->name = $request->name;
            $class->school_id =  $school_id;
            $class->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully created'
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function remove(Request $request, $class){
        try{
            $class = ClassDetail::find($class);
            $class->delete_flag = 1;
            $class->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted'
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}
