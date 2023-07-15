<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section_subject')->delete();

        $section_subject = [
            ['id'=>1,'section_id'=>4, 'subject_id' =>1 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>2,'section_id'=>4, 'subject_id' =>2 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>3,'section_id'=>4, 'subject_id' =>3,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>4,'section_id'=>4, 'subject_id' =>4 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>5,'section_id'=>4, 'subject_id' =>5 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>6,'section_id'=>4, 'subject_id' =>6 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>7,'section_id'=>4, 'subject_id' =>7 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>8,'section_id'=>4, 'subject_id' =>8 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>9,'section_id'=>4, 'subject_id' =>9 ,'subject_code'=>1,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
        ];

        DB::table('section_subject')->insert($section_subject);
    }
}
