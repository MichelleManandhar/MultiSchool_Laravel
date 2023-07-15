<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTeacher extends Model
{
    protected $table = "section_teacher";
    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }
    public function section(){
        return $this->belongsTo('App\Section');
    }
}
