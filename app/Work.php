<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['user_id', 'company_id', 'title', 'job_description', 'started_at'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function company(){
        return $this->belongsTo('App\Company');
    }

}
