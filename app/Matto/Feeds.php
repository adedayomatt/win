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
		$collection = collect([]);
		$feeds = $collection;
		$feeds = $collection->merge($this->trainings)
							->merge($this->comments)
							->merge($this->discussions)
							->sortByDesc('created_at');
            return $feeds->paginate(config('custom.pagination'));  								
	}
}
