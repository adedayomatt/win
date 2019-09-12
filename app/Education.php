<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['user_id','school_id', 'course', 'started_at', 'finished_at'];
    protected $dates = ['started_at','finished_at'];
    protected $appends = ['start', 'finish'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function school(){
        return $this->belongsTo('App\School');
    }
    public function getStartAttribute(){
        return $this->started_at == null ? null : $this->started_at->format('d/m/Y');
    }
    public function getFinishAttribute(){
        return $this->finished_at == null ? null : $this->finished_at->format('d/m/Y');
    }

}
