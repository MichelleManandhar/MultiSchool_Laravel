<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function class(){
        return $this->hasMany('App\ClassDetail');
    }
}
