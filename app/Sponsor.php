<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table="sponsors";
    public function student(){
        return $this->belongsTo('App\Student');
}
}