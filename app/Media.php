<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['experience_id', 'slug', 'type'];

    public function experience(){
        return $this->belongsTo('App\Experience');
    }
    public function isPhoto(){
        return $this->type == 'photo' ? true : false;
    }
    public function isVideo(){
        return $this->type == 'video' ? true : false;
    }

}
