<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use softDeletes;
	
    protected $fillable = ['user_id','post_category_id','title','content','slug','cover'];
	
	public function type(){
		return 'post';
	}

	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function PostCategory(){
		return $this->belongsTo('App\PostCategory');
		}
	public function category(){
			return $this->PostCategory();
		}

	public function discussions(){
		return $this->hasMany('App\Discussion');
	}

	public function tags(){
		return $this->belongsToMany('App\Tag');
	}
	public function tagIDs(){
		$tags = array();
		foreach($this->tags as $tag){
			array_push($tags, $tag->id);
		}
		return $tags;
	}
	
	public function relatedPosts(){
		$posts = collect([]);
		$related_posts = $posts;

		foreach($this->tagIDs() as $tag){
			$post_IDs = array();
		   $IDs = DB::select("select post_id from post_tag where tag_id=$tag");
		   foreach($IDs as $id){
			if($this->id !== $id->post_id) {
				array_push($post_IDs,$id->post_id);
			}  
		   }
			$related_posts = $posts->merge(Post::whereIn('id',$post_IDs)->get());
		}
	return $related_posts;
	}
	
	public function coverAvailable(){
		return $this->cover === null || !file_exists(public_path().'/storage/images/posts/'.$this->cover) ? false : true;
	}
	
	public function cover(){
		$image = array();
		$image['src'] = $this->cover === null ? asset('storage/images/posts/default.png') : asset('storage/images/posts/'.$this->cover);
		$image['alt'] =  $this->title. ' on '.config('app.name');
		return $image;
	}

	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),200);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}


}
