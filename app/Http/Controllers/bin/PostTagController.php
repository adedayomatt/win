<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Trainingtag;
use App\Traits\GetResource;

class TrainingTagController extends Controller
{
    
    use GetResource;

    public function __construct()
    {
        // $this->middleware('auth', ['except'=>['index', 'show']]);//This is to authenticate the user, only training list and single training view is publicly accessible
    }

    private function getTag($id){
        return $this->find(Trainingtag::class,$id);
    }

    public function search(Request $request){
    return Trainingtag::search($request->get('q'))
                    ->with('trainings')
                    ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('training.tag.index')->with('trainingtags',Trainingtag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training.tag.create');
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
		
		Trainingtag::create([
        'name' => $request->tag_name,
        'description' => $request->description,
        'slug' => str_slug($request->tag_name)
		]);
		return redirect()->route('training.tags')->with('success','Tag '.$request->tag_name.' created');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		return view('training.tag.show')->with('trainingtag', $this->getTag($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('training.tag.edit')->with('trainingtag', $this->getTag($id));
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
		return redirect()->route('training.tag.show',[$tag->slug])->with('success','Tag '.$request->tag_name.' updated');
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
