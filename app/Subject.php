<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table="subjects";
    protected $fillable = ['name'];
    public function class(){
        return $this->belongsToMany('App\Class');
    }

    public function teacher(){
        return $this->belongsToMany('App\Teacher');
    }

    public function examDetails(){
        return $this->hasMany('App\Exam_detail');
    }

    public function subject_marks(){
        return $this->hasMany(ExamSubject::class);
    }
}
