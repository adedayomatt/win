<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceLike extends Model
{
    protected $fillable = ['user_id','experience_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function experience(){
        return $this->belongsTo('App\Experience');
    }
}
