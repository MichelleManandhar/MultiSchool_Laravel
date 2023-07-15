<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->delete();

        $subjects = [
            ['id'=>1,'name'=>'English' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>2,'name'=>'Nepali' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>3,'name'=>'Math' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>4,'name'=>'Science' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>5,'name'=>'Social' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>6,'name'=>'Population' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>7,'name'=>'Computer' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>8,'name'=>'Accountancy' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>9,'name'=>'Health' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],

        ];

        DB::table('subjects')->insert($subjects);
    }
}
