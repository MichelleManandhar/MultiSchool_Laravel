<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionSubject extends Model
{
    protected $table="section_subject";
    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function examDetail(){
        return $this->hasMany('App\ClassDetail');
    }

    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }
}
