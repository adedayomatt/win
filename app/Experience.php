<?php

namespace App;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Experience extends Model
{
	use softDeletes, SearchableTrait;
	
	protected $fillable = ['user_id','title','content','slug','cover'];
	protected $hidden = ['content'];
	protected $appends = ['type','photos','videos','cover','discussions_count','experience_tags','snippet','createdat_timestamp'];
	protected $snippet_length = 200;

	protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'experiences.title' => 10,
            'experiences.content' => 10
		],
  ];


	public function user(){
		return $this->belongsTo('App\User');
	}

	public function category(){
			return $this->ExperienceCategory();
		}

	public function discussions(){
		return $this->hasMany('App\Discussion');
	}
	public function media(){
		return $this->hasMany('App\Media');
	}

	// Attributes APIs
	public function getTypeAttribute(){
		$this->user;
		return 'experience';
	}

	public function getPhotosAttribute(){
		return $this->photos();
	}
	public function getVideosAttribute(){
		return $this->videos();
	}
	public function getExperienceTagsAttribute(){
		return $this->tags()->pluck('slug');
	}

	public function getDiscussionsCountAttribute(){
		return $this->discussions()->count();
	}
	public function getSnippetAttribute(){
		return str_limit(strip_tags($this->content),$this->snippet_length).(strlen(strip_tags($this->content)) > $this->snippet_length ? '...' : '');
	}

	public function getCreatedatTimestampAttribute(){
		return $this->created_at->getTimestamp();
	}

	public function getCoverAttribute(){
		return $this->cover();
	}
	public function isTrashed(){
		return $this->deleted_at == null ? false : true;
	}

	public function tags(){
		return $this->belongsToMany('App\Tag');
	}
	public function tagIDs(){
		return $this->tags->pluck('id');
	}
	
	public function photos(){
		$photos = array();
		if($this->media->count() > 0){
			foreach($this->media as $media){
				if($media->isPhoto()){
					array_push($photos, $media);
				}
			}
		}
		return collect($photos);
	}

	public function videos(){
		$videos = array();
		if($this->media->count() > 0){
			foreach($this->media as $media){
				if($media->isVideo()){
					array_push($videos, $media);
				}
			}
		}
		return collect($videos);
	}

	public function cover(){
		$image = array();
		$image['src'] = $this->photos()->count() > 0 ? asset('storage/experiences/media/'.$this->photos()->first()->slug) : asset('storage/experiences/default.jpg');
		$image['alt'] =  $this->title. ' on '.config('app.name');
		return $image;
	}


	public function relatedExperiences(){
		$experiences = DB::table('experience_tag')->whereIn('tag_id',$this->tagIDs())->pluck('experience_id');
		return Experience::whereIn('id',$experiences)->where('id','!=',$this->id)->get();
	}
	

	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->snippet;
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}
	
	public function isMine(){
		return (Auth::check() && Auth::id() == $this->user_id) ? true : false;
	}

	// users that this experience is targeted at according to the tags
	public function reachableUsers(){
		return Tag::getFollowers($this->tags);
	}

}
