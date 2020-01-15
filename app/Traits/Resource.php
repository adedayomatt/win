<?php

namespace App\Traits;
use Auth;
use App\User;

trait Resource
{
    
    // Get and return a resource either by its ID or slug
    protected function find($model,$identifier){
        if(is_numeric($identifier)){
            return $model::findorfail($identifier);
        }
        else if(is_string($identifier)){
            return $model::where('slug',$identifier)->firstorfail();
        }
    }
    protected function generateSlug($model,$string){
        $lastEntry = $model::orderby('id','desc')->first();
        return $lastEntry == null ? str_slug($string) :str_slug($string.' '.($lastEntry->id + 1));
    }
    protected function updateSlug($resource,$string){
        return str_slug($string.' '.$resource->id);
    }
    // check if a request is from API or web
    protected function isAPIRequest(){
        return request()->is('api/*') || request()->wantsJson();
    }
    //the current user 
    protected function currentUser(){
		$user = null;
		if($this->isAPIRequest()){
			$token = \request()->get('api_token');
			if($token != null){
				$user = User::where('api_token', $token)->first();
			}
		}else{
			$user = Auth::user();
		}
		return $user;
	}


}
