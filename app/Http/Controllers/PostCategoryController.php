<?php

namespace App\Http\Controllers;

use App\PostCategory;
use Illuminate\Http\Request;
use App\Traits\Resource;

class PostCategoryController extends Controller
{
    use Resource;

    public function __construct()
    {
        // $this->middleware('auth', ['except'=>['index', 'show']]);//This is to authenticate the user, only post list and single post view is publicly accessible
    }
    
    private function getCategory($id){
        return $this->find(PostCategory::class,$id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.category.index')->with('postcategories', PostCategory::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('post.category.create');
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
		'name' => ['required','unique:post_categories']
		],[
            'unique' => 'The category already exist'
        ]);
		
		PostCategory::create([
        'name' => $request->name,
        'description' => $request->description,
        'slug' => str_slug($request->name)
		]);
		return redirect()->route('post.categories')->with('success','Category '.$request->name.' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		return view('post.category.show')->with('postcategory', $this->getCategory($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('post.category.edit')->with('postcategory', $this->getCategory($id));
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
            'name' => 'required'
				]);
        $category = $this->getCategory($id);
        // if(PostCategory::where([
        //     ['name',$request->name],
        //     ['slug',str_slug($request->name)],
        //     ['id', '!=', $category->id]
        //     ])->count() > 0){
        //         return redirect()->back()->with('warning','category already exist');
        //     }

		// $category->name = $request->name;
        $category->description = $request->description;
        // $category->slug = str_slug($request->name);
		$category->save();
		return redirect()->route('post.category.show',[$category->slug])->with('success','Category '.$request->name.' updated');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->getCategory($id);
        $category->delete();
		return redirect()->back()->with('success',$category->name.' deleted');
    }
}
