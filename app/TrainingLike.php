<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingLike extends Model
{
    protected $fillable = ['user_id','training_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function training(){
        return $this->belongsTo('App\Training');
    }
}
