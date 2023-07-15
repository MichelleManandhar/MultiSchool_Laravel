<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->delete();
        $teachers = [
            ['id'=>1 , 'name'=>'Nayanawati Guruma','designation'=>'Founder Director' , 'contact_no'=>'9841260715' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>2 , 'name'=>'Abha Awale','designation'=>'Principal' , 'contact_no'=>'9841344519' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>3 , 'name'=>'Jeevan Awale','designation'=>'Administrator' , 'contact_no'=>'9851045211' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>4 , 'name'=>'Diwakar Acharya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>5 , 'name'=>'Dirgha Raj Mishra','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>6 , 'name'=>'Gopal Krishna Bhattarai','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>7 , 'name'=>'Dinesh Silwal','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>8 , 'name'=>'Dhan Bdr. Kandangawa','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>9 , 'name'=>'Ramita Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>10 , 'name'=>'Nisha Bajracharya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>11, 'name'=>'Basudha Bajgain','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>12, 'name'=>'Kiran Maharjan00','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>13, 'name'=>'Teena Shrestha','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>14, 'name'=>'Dinesh Fadera','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>15, 'name'=>'Sangita Nakarmi','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>16, 'name'=>'Salina Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>17, 'name'=>'Sushma Bajracharya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>18, 'name'=>'Sheetal Dangol','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>19, 'name'=>'Jyoti Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>20, 'name'=>'Subhadra Shrestha','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>21, 'name'=>'Nirmala Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>22, 'name'=>'Rojina Shrestha','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>23, 'name'=>'Mandira Buddhacharya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>24, 'name'=>'Munu Basnet','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>25, 'name'=>'Sanam Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>26, 'name'=>'Angita K.C.','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>27, 'name'=>'Neelima Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>28, 'name'=>'Krishna Maharjan','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>29, 'name'=>'Dharma Raj Bista','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>30, 'name'=>'Devina Awale','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>31, 'name'=>'Suresh Bista','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>32, 'name'=>'Puja Ranjitkar','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>33, 'name'=>'Prem Bhatta','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>34, 'name'=>'Geeta Bhatta','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>35, 'name'=>'Dinesh Maharjan','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>36, 'name'=>'Sweta Giri','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>37, 'name'=>'Rojeena Pradhan','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>38, 'name'=>'Angita Subedi','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>39, 'name'=>'Angita Subedi','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>40, 'name'=>'Saleena Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>41, 'name'=>'Abna Duwal Awale','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ['id'=>42, 'name'=>'Ramita Shakya','designation'=>'' , 'contact_no'=>'' , 'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') ],
            ];
        DB::table('teachers')->insert($teachers);
    }
}
