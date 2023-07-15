<?php

namespace App\Http\Controllers;
use App\FeeCategory;
use Illuminate\Http\Request;
use Exception;
class FeeCategoryController extends Controller
{
    public function index( Request $request)
    {
//        $school_id = SchoolUser::where('user_id' ,$id )->first();
        $allFeeCategory = FeeCategory::where('school_id' ,$request->user()->school()->first()->id)->get();
        return response()->json([
            'status' => 1,
            'feeCategories' => $allFeeCategory
        ]);
    }

    public function store(Request $request)
    {
//        dd($request);
        try {
//            $id = $request->get('user');
//            $school = SchoolUser::where('user_id' ,$id )->first();
            $feeCategory = new FeeCategory();
            $feeCategory = $this->storeOrUpdateFeeCategory($request, $feeCategory);
            $feeCategory->school_id = $request->user()->school()->first()->id;
            $feeCategory->save();
            return response()->json(
                [
                    'status'=>1,
                    'exam'=>$feeCategory
                ]
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function storeOrUpdateFeeCategory(Request $request, FeeCategory $feeCategory)
    {
        try {
            $feeCategory ->name= $request->get('name');
            $feeCategory ->description= $request->get('description');
            $feeCategory->save();
            return $feeCategory;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit(Request $request, $fee)
    {
        try {
//            dd($feeCategory);
//           $this->storeOrUpdateFeeCategory($request, $feeCategory);
            $feeCategory  = FeeCategory::findorfail($fee);
            $feeCategory ->name= $request->get('name');
            $feeCategory ->description= $request->get('description');
            $feeCategory->save();
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function destroy(Request $request,FeeCategory $feeCategory){
        try{
            $feeCategory->delete_flag = 1;
            $feeCategory->save();
            return response()->json([
                'status' => 1,
                'exam' => $feeCategory
            ]);
        }
        catch(Exception $e){
            throw $e;
        }
    }
}
