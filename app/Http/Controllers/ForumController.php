<?php

namespace App\Http\Controllers;
use App\Forum;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    use Resource;

	public function __construct(){
		// $this->middleware('auth')->except(['index','show']);
    }

    private function getForum($id){
        return $this->find(Forum::class,$id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum.index')->with('forums',Forum::Orderby('created_at','desc')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.create');
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
        'forum_name' => 'required',
        ]);
        
		Forum::create([
            'user_id' => Auth::user()->id,
            'name' => $request->forum_name,
            'description' => $request->description,
            'slug' => $this->generateSlug(Forum::class,$request->forum_name)
		]);
		return redirect()->back()->with('success', 'Forum '.$request->name.' created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('forum.show')->with('forum', $this->getForum($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('forum.edit')->with('forum', $this->getForum($id));
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
		'forum_name' => 'required'
		]);

        $forum = $this->getForum($id);
		$forum->name = $request->forum_name;
		$forum->description = $request->description;
		$forum->slug = $this->updateSlug($forum,$request->forum_name);
		
		return redirect()->back()->with('success', 'Forum '.$forum->name.' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $forum = $this->getForum($id);
	   $forum->delete();
		 return redirect()->back()->with('success', 'Forum '.$forum->name.' deleted');

    }
}
