<?php

namespace App\Http\Controllers;

use App\School;
use App\Traits\Resource;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    use Resource;
    public function __construct(){

    }

    public function search(Request $request){
        return School::search($request->get('q'))
                        ->with('educations')
                        ->get();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if($this->isAPIRequest()){
            $school = null;
            if($request->has('school') && $request->school != ''){
                $school = School::where('name', $request->school)->first();
                if($school == null){
                    $school = School::create([
                        'name' => $request->school
                    ]);
                }
            }
            return response($school);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
