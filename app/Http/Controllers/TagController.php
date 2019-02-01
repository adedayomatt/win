<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\Traits\Resource;

class TagController extends Controller
{
    
    use Resource;

    public function __construct()
    {
        // $this->middleware('auth', ['except'=>['index', 'show']]);//This is to authenticate the user, only post list and single post view is publicly accessible
    }

    private function getTag($id){
        return $this->find(Tag::class,$id);
    }

    public function search(Request $request){
    return Tag::search($request->get('q'))
                    ->with('posts')
                    ->with('discussions')
                    ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tag.index')->with('tags',Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
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
            'name' => 'required|unique:tags',
         ],[
             'unique' => 'Tag already exist'
         ]);
		
		Tag::create([
        'name' => $request->name,
        'description' => $request->description,
        'slug' => str_slug($request->name)
		]);
		return redirect()->route('tags')->with('success','Tag '.$request->name.' created');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		return view('tag.show')->with('tag', $this->getTag($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('tag.edit')->with('tag', $this->getTag($id));
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
		// $this->validate($request,[
		// 		'name' => 'required'
		// 		]);
		
		$tag = $this->getTag($id);
        // $tag->name = $request->name;
        $tag->description = $request->description;
        // $tag->slug = str_slug($request->name);
		$tag->save();
		return redirect()->route('tag.show',[$tag->slug])->with('success','Tag '.$request->name.' updated');
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getTag($id)->delete();
		return redirect()->back()->with('success','Tag deleted');
    }
}
