<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    protected $table = 'exam_subjects';

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function marks(){
        return $this->hasMany(Mark::class);
    }
}
