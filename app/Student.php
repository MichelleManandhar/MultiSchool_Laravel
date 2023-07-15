<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function marks()
    {
       return $this->hasMany('App\Mark','student_id');
    }

    public function attendance(){
        return $this->hasOne('App\Attendance');
    }

    public function studentHistory(){
        return $this->hasOne('App\StudentHistory','student_id');
    }
}
