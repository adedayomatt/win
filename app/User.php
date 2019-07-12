<?php

namespace App;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,softDeletes, SearchableTrait;

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
	protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.firstname' => 10,
            'users.lastname' => 10,
            'users.username' => 10
		],
  ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }
    public function sendPasswordResetNotification($token){
		$this->notify(new \App\Notifications\PasswordResetNotification($token));
	}  


	public function trainings(){
		return $this->hasMany('App\Training');
    }
    public function discussions(){
		return $this->hasMany('App\Discussion');
	}
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function tagsFollowing(){
        return $this->belongsToMany('App\Tag');
    }

    public function tags(){
        return $this->hasMany('App\Tag');
      }

    public function forums(){
        return $this->hasMany('App\Forum');
      }

      public function commentsLikes(){
        return $this->hasMany('App\CommentLike');
    }
	public function watchings(){
		return $this->hasMany('App\Watch');
    }
    public function discussionInvitations(){
		return $this->belongsToMany('App\Discussion');
    }
    public function work(){
		return $this->hasOne('App\Work');
    }
	public function education(){
		return $this->hasOne('App\Education');
    }

    public function emailVerified(){
        return $this->email_verified_at == null ? false : true;
    }
    public function isVerified(){
        return $this->verified_at == null ? false : true;
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
		foreach($this->tagsFollowing as $tag){
			array_push($tags, $tag->id);
		}
		return $tags;
    }

    public function isFollowing($tag){
        return in_array($tag->id, $this->interests()) ? true : false;
    }

    public function interestedDiscussions(){
		$discussions = [];
		foreach($this->interests() as $interest){//Get discussions that has the tags user is following
		   $IDs = DB::select("select discussion_id from discussion_tag where tag_id=$interest");
           foreach($IDs as $id){
                $discussion = Discussion::where('id',$id->discussion_id)->first();
                if($discussion != null){
                    array_push($discussions, $discussion);
                }
		   }
        }
        return collect($discussions);
    }

    public function interestedTrainings(){
		$trainings = [];
		foreach($this->interests() as $interest){//Get trainings that has the tags user is following
			$training_IDs = array();
		   $IDs = DB::select("select training_id from tag_training where tag_id=$interest");
		   foreach($IDs as $id){
               $training = Training::where('id',$id->training_id)->first();
               if($training != null){
                array_push($trainings, $training);
               }
		   }
		}
	return collect($trainings);
    }

    public function discussionContributions($raw = false){
        $query = Comment::select(DB::raw('count(discussion_id) as total_comments, discussion_id'))->where('user_id', $this->id)->groupBy('discussion_id')->orderBy('created_at', 'desc');
       return  $raw == true ? $query : $query->get();
    }
    
    public function activeDiscussions($raw = false){
        $discussions = [];
        foreach($this->discussionContributions(true)->orderby('total_comments','desc')->get() as $contribution){
            array_push($discussions, $contribution->discussion);
        }
        return collect($discussions);
    }
    public function hasEducation(){
        return $this->education == null ? false : true;
    }
    public function educationStatus(){
        $status = "";
        if($this->hasEducation()){
            $status .= ($this->education->finished_at != null && $this->education->finished_at < now() ? 'studied ' : 'studying ')
                        .($this->education->course != null ? $this->education->course : '')
                        .' at '.$this->education->school->name;
        }
        return $status;
    }
    public function hasWork(){
        return $this->work == null ? false : true;
    }
    public function workStatus(){
        $status = "";
        if($this->hasWork()){
            $status .= ($this->work->position != null ? $this->work->position.' at ': 'Works at ').$this->work->company->name;
        }
        return $status;
    }

}
