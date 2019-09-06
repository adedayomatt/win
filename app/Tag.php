<?php

namespace App;
use App\User;
use App\Matto\Feeds;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
	use SearchableTrait;
	
  protected $fillable = ['user_id','name','description','slug'];
  protected $appends = ['type','trainings_count','discussions_count'];
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
  

  // Static functions
  public static function trending(){
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

  // return collection of users following an collection of tags
  public static function getFollowers($tags){
    $followers_id = [];
    foreach($tags as $tag){
        foreach($tag->users as $user){
            if(!in_array($user->id, $followers_id)){
                array_push($followers_id, $user->id);
            }
        }
    }
    return User::whereIn('id', $followers_id)->get();
  }

  // Relationships
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

// Attributes
public function getTypeAttribute(){
    $this->user;
    $this->users;
}
public function getTrainingsCountAttribute(){
  return $this->trainings()->count();
}

public function getDiscussionsCountAttribute(){
  return $this->discussions()->count();
}
function getFeedsAttribute(){
  $feeds = new Feeds($this->discussions, $this->trainings);
  return $feeds->feeds();
}


  public function otherTags($raw = false){
    $builder = Tag::where('id','!=', $this->id);
    return $raw == true ? $builder : $builder->get();
  }

  public function followersId(){
    $followers = [];
    foreach($this->followers as $user){
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
