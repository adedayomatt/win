<?php

namespace App\Matto;
class feeds
// This class is to arrange feeds, discussion, experiences and comment collections are passed to the constructor
{
    public $experiences = null;
    public $comments = null;
    public $discussions = null; 


    public function __construct($discussions = null,$experiences= null,$comments=null){
        $this->discussions = $discussions == null ? collect([]) : $discussions;
        $this->experiences = $experiences == null ? collect([]) : $experiences;
        $this->comments = $comments == null ? collect([]) : $comments;
    }

    public function feeds(){
		$feeds = collect([])->merge($this->experiences)
							->merge($this->comments)
                            ->merge($this->discussions);
        return $feeds->sortByDesc('created_at')->paginate(config('custom.pagination'));  								
	}
}
