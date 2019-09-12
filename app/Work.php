<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['user_id', 'company_id', 'title', 'job_description', 'started_at'];
    protected $dates = ['started_at'];
    protected $appends = ['start'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function company(){
        return $this->belongsTo('App\Company');
    }
    public function getStartAttribute(){
        return $this->started_at == null ? null : $this->started_at->format('d/m/Y');
    }

}
