<?php

namespace App\Http\Controllers;

use App\Fee;
use App\FeeBill;
use App\FeeCategory;
use App\FeeDetail;
use App\FeePayment;
use App\Section;
use App\SectionFee;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Psy\Util\Json;
use Carbon\Carbon;

class FeeController extends Controller
{
//    const student_not_deleted_status =  0 ;
    public function getFeesStudent(Section $section, Request $request)
    {
        try {
            $carbon = Carbon::now();
            $result = [];
            $students = $section->student()->select(['id', 'roll_no','section_id'])->selectRaw("CONCAT(IFNULL(fname,''),' ',IFNULL(mname,''),' ',IFNULL(lname,'')) as name")
                ->where('delete_flag', 0)->orderBy('roll_no', 'ASC')->get();
            $feeCategories = FeeCategory::where('school_id' ,$request->user()->school()->first()->id )->get();
            foreach ($students as $student) {
                $sum = 0;
                $bills = FeeBill::where('fee_bills.year', $carbon->year)->where('fee_bills.month', $carbon->month)->where('fee_bills.student_id', $student->id)->orderBy('fee_bills.updated_at', 'desc')
                    ->join('fee_details' , 'fee_details.fee_bill_id' , 'fee_bills.id')
                    ->first();
                if(isset($bills) ){
                    $billpayment = FeePayment::where('fee_bill_id' , $bills->fee_bill_id)->orderBy('updated_at', 'desc')->first();
                    foreach ($feeCategories as $fee) {
                        $studentFee = Fee::where('fee_bill_id', $bills->fee_bill_id)->where('fee_category_id', $fee->id)->first();
                        $sectionFee =  SectionFee::where('section_id' ,$student->section_id )->where('fee_category_id' , $fee->id)->first();
                        if(isset($studentFee) && isset($sectionFee)){
                            $student[$fee->name] = $studentFee->amount != 0   ? $studentFee->amount : $sectionFee->amount;
                            $sum   = $sum + isset($studentFee) ?  $studentFee->amount : 0;
                        }
                    }
                    $student['dueAmount'] = isset($bills) ? $bills->dueAmount : 0;
                    $student['total']  = isset($bills) ? $bills->total : null;
                    $student['paid_fee']  = isset($billpayment) ? $billpayment->totalpaidAmount  : 0;}
                array_push($result, $student);
            }
            return $result;
        }
        catch(\Exception $e){
            throw $e;
        }
    }
    public function getSectionFee( Request $request  , $section)
    {
        try {
            $feeCategories = FeeCategory::where('school_id' ,$request->user()->school()->first()->id )->get();
            $array = [];
            foreach ($feeCategories as $fee){
                $sectionFee =  SectionFee::where('section_id' ,$section )->where('fee_category_id' , $fee->id)->first();
                $array[$fee->name] =isset($sectionFee)  ? $sectionFee->amount : null;
            }
            return $array;

        }
        catch(\Exception $e){
            throw $e;
        }
    }


    public function storeOrUpdateSectionFee(Request $request , $section)
    {
        try {
            $students  =  Student::where('section_id', $section )->where('delete_flag' , 0)->get();
            $feeCategories = FeeCategory::where('school_id' , $request->user()->school()->first()->id)->get();
            foreach ($feeCategories as $cat){
                $sectionFee = SectionFee::where('fee_category_id', '=', $cat->id)->where('section_id', '=', $section)->first();
                if ($sectionFee == '') {
                    $sectionFee = new SectionFee();
                }
                $sectionFee->section_id = $section;
                $sectionFee->fee_category_id = $cat->id;
                $sectionFee->amount= $request->get($cat->name);
                $sectionFee->save();
                foreach ($students as $student){
                    $this->storeStudentFeeBasedOnSectionFee($sectionFee->id , $section , $student);}
            }
            return response()->json([
                'status' => 1,
                'message' => 'Fee Setup Successfull'
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function storeOrUpdateStudentFee(Request $request , $section , $student){
        try {
            $sum = 0;
            $feeCategories = FeeCategory::where('school_id' , $request->user()->school()->first()->id)->get();
            $fee_bill =  FeeBill::where('student_id' , $student)->orderBy('updated_at', 'desc')->first();
            foreach ($feeCategories as $cat){
                $studentFee = Fee::where('fee_category_id', '=', $cat->id)->where('section_id', '=', $section)->where('student_id', '=', $student)->first();
                if ($studentFee == '') {
                    $studentFee = new Fee();
                }
                $studentFee->student_id = $student;
                $studentFee->section_id = $section;
                $studentFee->fee_bill_id =  $fee_bill->id;
                $studentFee->fee_category_id = $cat->id;
                $studentFee->amount= $request->get($cat->name)!==null?$request->get($cat->name):0;
                $sum  = $sum +$studentFee->amount;
                $studentFee->save();
            }
            $feeDetail = FeeDetail::where('student_id' , $student)->first();
            if($feeDetail == ''){
                $feeDetail = new FeeDetail();
            }
            $feeDetail-> student_id = $student;
            $feeDetail->section_id = $section;
            $feeDetail->dueAmount = $request->get('dueAmount');
            $feeDetail->scholarship = $request->get('scholarship');
            $feeDetail->total = $sum ;
            $feeDetail->save();
            return response()->json([
                'status' => 1,
                'message' => 'Fee Added Successfull'
            ]);

        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function storeStudentFeeBasedOnSectionFee($sectionfeeid , $section , $student){
        $fee_bill =  FeeBill::where('student_id' , $student->id)->orderBy('updated_at', 'desc')->first();
        $sectionfee = SectionFee::find( $sectionfeeid);
        $studentfee =  Fee::where('fee_category_id' , $sectionfee->fee_category_id)->where('fee_bill_id' ,$fee_bill->id )->first();
        if(isset($studentfee)){
            if($studentfee->amount = 0 ){
                $studentfee->amount =  $sectionfee->amount;
            }
        }
        else{
            $studentfee = new Fee();
            $studentfee->student_id =  $student->id;
            $studentfee->section_id =  $section;
            $studentfee->fee_bill_id =  $fee_bill->id;
            $studentfee->fee_category_id =  $sectionfee->fee_category_id;
            $studentfee->amount =  $sectionfee->amount;
            $studentfee->save();
        }
        $feeDetail =  FeeDetail::where('fee_bill_id' ,$fee_bill->id )->first();
        dd($feeDetail);
        $feeDetail->total = $feeDetail->total + $studentfee->amount ;
        $feeDetail->save();
    }
}
