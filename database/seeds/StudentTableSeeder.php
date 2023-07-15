<?php
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    public function __construct()
    {
        $this->table = 'student';
        $this->filename = base_path().'/database/seeds/csvs/your_csv.csv';
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        parent::run();
    }
}
