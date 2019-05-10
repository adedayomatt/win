<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','username', 'email', 'password','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


	public function posts(){
		return $this->hasMany('App\Post');
    }
    public function discussions(){
		return $this->hasMany('App\Discussion');
	}
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function commentsLikes(){
        return $this->hasMany('App\CommentLike');
    }
	public function watchings(){
		return $this->hasMany('App\Watch');
    }
    
    public function fullname(){
        return $this->firstname.' '.$this->lastname;
    }
    public function username(){
        return '@'.$this->username;
    }

	public function avatar(){
		$image = array();
		$image['src'] = $this->avatar === null ? asset('storage/images/users/default.png') : asset('storage/images/users/'.$this->avatar);
		$image['alt'] = $this->fullname().'('.$this->username().') on '.config('app.name');
		return $image;
    }
    
    public function auth(){
        return $this->id === Auth::id() ? true : false;
    }

    public function interests(){
        $tags = array();
		foreach($this->tags as $tag){
			array_push($tags, $tag->id);
		}
		return $tags;
    }

    public function interestedDiscussions(){
		$discussions = collect([]);
		$interested_discussions = $discussions;

		foreach($this->interests() as $interest){//Get discussions that has the tags user is following
			$discussion_IDs = array();
		   $IDs = DB::select("select discussion_id from discussion_tag where tag_id=$interest");
		   foreach($IDs as $id){
				array_push($discussion_IDs,$id->discussion_id);
		   }
			$interested_discussions = $discussions->merge(Discussion::whereIn('id',$discussion_IDs)->get());
		}
	return $interested_discussions;
    }

    public function interestedPosts(){
		$posts = collect([]);
		$interested_posts = $posts;

		foreach($this->interests() as $interest){//Get posts that has the tags user is following
			$post_IDs = array();
		   $IDs = DB::select("select post_id from post_tag where tag_id=$interest");
		   foreach($IDs as $id){
				array_push($post_IDs,$id->post_id);
		   }
			$interested_posts = $posts->merge(Post::whereIn('id',$post_IDs)->get());
		}
	return $interested_posts;
    }
    
}
