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
		$this->middleware(['auth','verified'])->except(['search','index','show']);
    }

    public function search(Request $request){
        return Forum::search($request->get('q'))
                            ->with('discussions')
                            ->with('user')
                            ->get();
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
        return view('forum.index')->with('forums',Forum::Orderby('created_at','desc')->paginate(config('app.pagination')));
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
        if(Forum::where('name', $request->forum_name)->count() > 0){
            return redirect()->back()->with('error', 'Forum '.$request->name.' already exist');
        }
		$forum = Forum::create([
            'user_id' => Auth::user()->id,
            'name' => $request->forum_name,
            'description' => $request->description,
            'slug' => $this->generateSlug(Forum::class,$request->forum_name)
		]);
		return redirect()->route('forum.show',[$forum->slug])->with('success', 'Forum '.$request->name.' created successfully');
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
		// $forum->slug = $this->updateSlug($forum,$request->forum_name);
		$forum->save();
		return redirect()->route('forum.show',[$forum->slug])->with('success', 'Forum '.$forum->name.' updated');
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
