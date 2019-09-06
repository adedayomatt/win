<?php

namespace App\Matto;
class feeds
// This class is to arrange feeds, discussion, trainings and comment collections are passed to the constructor
{
    public $trainings = null;
    public $comments = null;
    public $discussions = null; 


    public function __construct($discussions = null,$trainings= null,$comments=null){
        $this->discussions = $discussions == null ? collect([]) : $discussions;
        $this->trainings = $trainings == null ? collect([]) : $trainings;
        $this->comments = $comments == null ? collect([]) : $comments;
    }

    public function feeds(){
		$feeds = collect([])->merge($this->trainings)
							->merge($this->comments)
							->merge($this->discussions);
        return $feeds->sortByDesc('created_at')->paginate(config('custom.pagination'));  								
	}
}
