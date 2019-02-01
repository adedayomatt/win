<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Matto\FileUpload;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
	use Resource;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['except'=>['index', 'show']]);//This is to authenticate the user, only post list and single post view is publicly accessible
    }

    private function getPost($id){
        return $this->find(Post::class,$id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
			'post_title' => 'required',
			'post_content' => 'required',
			'category' => 'required',
			'cover_image' => 'image|nullable|max:1999'
        ]);
        
    $post = new Post();
	$post->title = $request->post_title;
 	$post->user_id = auth()->user()->id;
   $post->post_category_id = $request->category;
	$post->content = $request->post_content;
    $post->slug = $this->generateSlug(Post::class,$request->post_title);
    if($request->hasFile('cover')){
        $upload = new FileUpload(
            $request,
            $name = 'cover',
            $title = $post->slug,
            $path = 'public/images/posts/'
        );
        $post->cover = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
    }
	$post->save();
	$post->tags()->attach($request->tags);
	
	return redirect()->route('post.show',$post->slug)->with('success','Post published!');
		}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->getPost($id);
		return view('post.show')->with('post',$post);
    }

    public function discuss($post){
        $post = $this->getPost($post);
        return view('discussion.create')->with('post',$post);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->getPost($id);
		return view('post.edit')->with('post',$post);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[ 
			'post_title' => 'required',
			'post_content' => 'required',
			'category' => 'required',
			'cover_image' => 'image|nullable|max:1999'
        ]);
        
    $post = $this->getPost($id);
    $post->post_category_id = $request->category;
	$post->title = $request->post_title;
	$post->content = $request->post_content;
    $post->slug = $this->generateSlug($post,$request->post_title);
    if($request->hasFile('cover')){
        $upload = new FileUpload(
            $request,
            $name = 'cover',
            $title = $post->slug,
            $path = 'public/images/posts/'
        );
        $post->cover = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
    }
	$post->save();
    $post->tags()->sync($request->tags);
    
	return redirect()->route('post.show',$post->slug)->with('success','Post updated!');
	}	

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->getPost($id);
		if(auth()->user()->id !== $post->user_id){
			return redirect()->route('post.show',[$id])->with('error','You are not authorized to edit that post');
		}
		else{
			// if($post->cover_image !== null && $post->cover_image != 'default_image.jpg'){
			// 	unlink(public_path().'/storage/images/posts/'.$post->cover);
			// }
		$post->delete();
		return redirect()->route('post.index')->with('success','Post deleted!');
		}
    }

}
