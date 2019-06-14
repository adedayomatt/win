<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['training_id', 'slug', 'type'];

    public function training(){
        return $this->belongsTo('App\Training');
    }
    public function isPhoto(){
        return $this->type == 'photo' ? true : false;
    }
    public function isVideo(){
        return $this->type == 'video' ? true : false;
    }

}
