<?php

namespace App\Http\Controllers;

use App\Fee;
use App\FeeBill;
use App\FeeCategory;
use App\FeeDetail;
use App\FeePayment;
use App\Section;
use App\SectionFee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeePaymentController extends Controller
{
    public function index(Request $request, Section $section){
        try {
            $carbon = Carbon::now();
            $result = [];
            $students = $section->student()->select(['id', 'roll_no','section_id'])->selectRaw("CONCAT(IFNULL(fname,''),' ',IFNULL(mname,''),' ',IFNULL(lname,'')) as name")
                ->where('delete_flag', 0)->orderBy('roll_no', 'ASC')->get();
            foreach ($students as $student) {
                $bills = FeeBill::where('fee_bills.year', $carbon->year)->where('fee_bills.month', $carbon->month)->where('fee_bills.student_id', $student->id)->orderBy('fee_bills.updated_at', 'desc')
                    ->join('fee_details' , 'fee_details.fee_bill_id' , 'fee_bills.id')->first();
                $feePaid = FeePayment::where('fee_bill_id' , $bills->id)->orderBy('updated_at', 'desc')->first();
                $student['total_payable']  = isset($bills) ? $bills->total + $bills->dueAmount : 0;
                array_push($result, $student);
            }
            return $result;
        }
        catch(\Exception $e){
            throw $e;
        }
    }
    public function storePayment(Request $request, $section , $student){
        $bill =  FeeBill::where('student_id', $student)->orderBy('updated_at', 'desc')->first();
        $fee_bill = FeeDetail::where('fee_bill_id' , $bill->id)->first();
        if($fee_bill->dueAmount > 0){
            $fee_bill->dueAmount = $fee_bill->dueAmount - $request->get('paid');
            if($fee_bill->dueAmount < 0 ){
                $fee_bill->total =  $fee_bill->total + $fee_bill->dueAmount;
                $fee_bill->dueAmount = 0 ;
            }
        }else{
            $fee_bill->total =  $fee_bill->total - $request->get('paid');
        }
        $fee_bill->save();
        $feePaid = FeePayment::where('fee_bill_id' , $bill->id)->orderBy('updated_at', 'desc')->first();
        $prevtotaapaid =isset($feePaid)?$feePaid->totalpaidAmount: 0;
        $payment =  new FeePayment();
        $payment-> student_id =  $student;
        $payment-> section_id =  $section;
        $payment-> fee_bill_id =  $bill->id;
        $payment->remainingAmount =  $fee_bill->total;
        $payment->totalpaidAmount =  $prevtotaapaid + $request->get('paid');
        $payment->paidAmount =  $request->get('paid');
        $payment->save();
        return response()->json([
            'status' => 1,
            'message' => 'Fee Bill payment successfully'
        ]);
    }
}
