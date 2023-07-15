<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassDetail extends Model
{
    protected $table="classes";
    protected $fillable = ['name'];


    public function examDetail(){
        return $this->hasMany('App\Exam_detail');
    }

    public function section(){
        return $this->hasMany('App\Section','class_id');
    }
}
