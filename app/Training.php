<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable =['training_category_id','title','content','media','slug'];

	public function TrainingCategory(){
		return $this->belongsTo('App\TrainingCategory');
        }
        
	public function category(){
			return $this->TrainingCategory();
		}

	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),50);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}
	}
