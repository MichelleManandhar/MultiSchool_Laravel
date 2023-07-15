<?php

use App\ClassDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('classes')->delete();

        $classes = [
            ['id'=>1,'name'=>'Pre-Nursery' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>2,'name'=>'Nursery' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>3,'name'=>'LKG' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>4,'name'=>'UKG' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>5,'name'=>'One' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>6,'name'=>'Two' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>7,'name'=>'Three' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>8,'name'=>'Four' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>9,'name'=>'Five' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>10,'name'=>'Six' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>11,'name'=>'Seven' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>12,'name'=>'Eight' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>13,'name'=>'Nine' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>14,'name'=>'Ten' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ];

        DB::table('classes')->insert($classes);
    }
}
