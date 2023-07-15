<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_detail extends Model
{
    public function class()
    {
        return $this->belongsTo('App\ClassDetail');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
}
