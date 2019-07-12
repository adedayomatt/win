<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['user_id', 'type', 'plan','link_to','expires_at'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function media(){
        return $this->hasMany('App\PromotionMedia');
    }
}
