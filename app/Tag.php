<?php

namespace App;
use App\Matto\Feeds;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
	use SearchableTrait;
	
	protected $fillable = ['user_id','name','description','slug'];

	  /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'tags.name' => 10,
            'tags.description' => 10
        ],
  ];
  
  static function trending(){
    $trendArray = array();
    foreach(Tag::all() as $tag){
      $trend = 0;
      $trend += $tag->trainings->count();
      $trend += $tag->discussions->count();
      foreach($tag->discussions as $discussion){
        $trend += $discussion->comments->count();
      }
      $trendArray[] = (object) [
        'tag' => $tag,
        'trend' => $trend,
        'discussions' => $tag->discussions,
        'trainings' => $tag->trainings
      ];
    }
    // dd(collect($trendArray));
    return collect($trendArray)->sortByDesc('trend');
  }

  public function user(){
    return $this->belongsTo('App\User');
  }
  
	public function trainings(){
		return $this->belongsToMany('App\Training');
    }

    public function discussions(){
		return $this->belongsToMany('App\Discussion');
    }

  public function users(){
		return $this->belongsToMany('App\User');
  }

  public function otherTags($raw = false){
    $builder = Tag::where('id','!=', $this->id);
    return $raw == true ? $builder : $builder->get();
  }

  public function feeds(){
    $feeds = new Feeds($this->discussions, $this->trainings);
    return $feeds->feeds();
  }
  public function followers(){
    return $this->users()->orderBy('created_at')->get();
  }
  public function followersId(){
    $followers = [];
    foreach($this->users as $user){
      array_push($followers, $user->id);
    }
    return $followers;
  }
  
  public function following($user_id){
    return in_array($user_id,$this->followersId()) ? true : false;
  }

	public function description($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->description == null ? '': str_limit(strip_tags($this->description),50);
		}
		return $this->description == null ? '': $this->description;
  }
  

}
