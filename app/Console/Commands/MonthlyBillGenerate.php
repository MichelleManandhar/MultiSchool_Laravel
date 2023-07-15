<?php

namespace App\Console\Commands;

use App\Fee;
use App\FeeBill;
use App\FeeCategory;
use App\FeeDetail;
use App\SectionFee;
use App\Student;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MonthlyBillGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Bill ID every month for students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $students = Student::all();
        $now = Carbon::now();
        foreach ($students as $student){
            $sum = 0 ;
            $feeBill = new FeeBill();
            $feeBill->student_id = $student->id;
            $feeBill->year = $now->year;
            $feeBill->month = $now->month;
            $feeBill->save();
            $feeCategories = FeeCategory::all();
            foreach ($feeCategories as $cat){
                $fees = Fee::where('student_id' , $student->id)->where('fee_category_id' , $cat->id)->first();
                if($fees != null){
                    $fees->fee_bill_id = $feeBill->id;
                    $fees->save();
                    $secFee = isset($fees) ? $fees->amount : 0;
                    $sum = $sum + $secFee;
                }
                else{
                    $fee = new Fee();
                    $fee->section_id  = $student->section_id;
                    $fee->student_id  = $student->id;
                    $fee->fee_category_id  = $cat->id;
                    $fee->fee_bill_id  = $feeBill->id;
                    $fee->save();
                    $sectionFee =  SectionFee::where('section_id' ,$student->section_id )->where('fee_category_id' , $cat->id)->first();
                    $secFee = isset($sectionFee) ? $sectionFee->amount : 0;
                    $sum = $sum + $secFee;
                }
            }
            $feeDetail = FeeDetail::where('student_id' , $student->id)->first();
            if($feeDetail != null){
                $feeDetail->fee_bill_id = $feeBill->id;
                $feeDetail->dueAmount = $feeDetail->total;
                $feeDetail->total  = $feeDetail->dueAmount + $sum;
                $feeDetail->save();
            }
            else{
                $feeDetail = new FeeDetail();
                $feeDetail->section_id  = $student->section_id;
                $feeDetail->student_id  = $student->id;
                $feeDetail->fee_bill_id  = $feeBill->id;
                $feeDetail->save();
            }
        }
        $this->info('New Bil Id are generated successfully');
    }
}

