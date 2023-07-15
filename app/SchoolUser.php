<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    protected $table = "school_user";
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function school(){
        return $this->belongsTo('App\School_info');
    }
}
