<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussiontag;
use App\Traits\GetResource;

class DiscussionTagController extends Controller
{
    
    use GetResource;

    public function __construct()
    {
        // $this->middleware('auth', ['except'=>['index', 'show']]);//This is to authenticate the user, only Discussion list and single Discussion view is publicly accessible
    }

    private function getTag($id){
        return $this->find(Discussiontag::class,$id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('discussion.tag.index')->with('discussiontags',Discussiontag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discussion.tag.create');
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
		'tag_name' => 'required'
		]);
		
		Discussiontag::create([
        'name' => $request->tag_name,
        'description' => $request->description,
        'slug' => str_slug($request->tag_name)
		]);
		return redirect()->route('discussion.tags')->with('success','Tag '.$request->tag_name.' created');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		return view('discussion.tag.show')->with('discussiontag', $this->getTag($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('discussion.tag.edit')->with('discussiontag', $this->getTag($id));
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
				'tag_name' => 'required'
				]);
		
		$tag = $this->getTag($id);
        $tag->name = $request->tag_name;
        $tag->description = $request->description;
        $tag->slug = str_slug($request->tag_name);
		$tag->save();
		return redirect()->route('discussion.tag.show',[$tag->slug])->with('success','Tag '.$request->tag_name.' updated');
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
