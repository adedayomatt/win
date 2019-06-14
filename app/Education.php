<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['user_id','school_id', 'course', 'started_at', 'finished_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function school(){
        return $this->belongsTo('App\School');
    }
}
