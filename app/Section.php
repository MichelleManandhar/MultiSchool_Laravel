<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function student(){
        return $this->hasMany('App\Student');
    }
    public function subject(){
        return $this->belongsToMany('App\Subject');
    }

    public function sectionSubject(){
        return $this->hasMany('App\SectionSubject');
    }

    public function attendance(){
        return $this->hasMany('App\Attendance');
    }

    public function marks(){
        return $this->hasMany('App\Mark');
    }

    public function classDetail(){
        return $this->belongsTo('App\ClassDetail','class_id');
    }
}
