<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section_teacher')->delete();

        $section_teacher= [
            ['id'=>1,'section_id'=>4,'teacher_id'=>1,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>2,'section_id'=>4,'teacher_id'=>2,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>3,'section_id'=>4, 'teacher_id'=>3,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>4,'section_id'=>4,'teacher_id'=>4,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>5,'section_id'=>4,'teacher_id'=>5,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>6,'section_id'=>4, 'teacher_id'=>6,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>7,'section_id'=>4,'teacher_id'=>7,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>8,'section_id'=>4,'teacher_id'=>8,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>9,'section_id'=>4,'teacher_id'=>9,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],

        ];

        DB::table('section_teacher')->insert($section_teacher);
    }
}
