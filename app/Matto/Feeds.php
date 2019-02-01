<?php

namespace App\Matto;
class feeds

{
    public $posts = null;
    public $comments = null;
    public $discussions = null; 


    public function __construct($discussions = null,$posts= null,$comments=null){
        $this->discussions = $discussions == null ? collect([]) : $discussions;
        $this->posts = $posts == null ? collect([]) : $posts;
        $this->comments = $comments == null ? collect([]) : $comments;
    }

    public function feeds(){
		$collection = collect([]);
		$feeds = $collection;
		$feeds = $collection->merge($this->posts)
							->merge($this->comments)
							->merge($this->discussions)
							->sortByDesc('created_at');
            return $feeds ;  								
	}
}
