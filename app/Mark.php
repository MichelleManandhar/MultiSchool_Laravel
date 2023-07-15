<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function subjectMarks(){
        return $this->belongsTo(ExamSubject::class,'exam_subject_id');
    }
}
