<?php

namespace App\Traits;


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
        return str_slug($string.' '.($lastEntry->id + 1));
    }
    protected function updateSlug($resource,$string){
        return str_slug($string.' '.$resource->id);
    }

}
