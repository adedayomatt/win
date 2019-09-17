<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Artisan;
use App\User;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemController extends Controller
{

    
    public function index(){
        return view('system.index');
    }

    public function clearSystemCache(){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return response(['success'=> true, 'message' => 'System cache cleared!']);
        //return redirect()->back()->with('info','System cache cleared!');
    }

    public function runArtisan(Request $request){
        ini_set('max_execution_time', 1000);
        $this->validate($request,[
            'command' => 'required',
        ]);
        $command = $request->command;
        $outputs = [];
        $success = false;

        $parameters = array();
        if($request->has('parameters') && count($request->parameters) > 0){
            for($i = 0;$i< count($request->parameters); ++$i){
                if($request->parameters[$i] != null && $request->values[$i] != null){
                    $parameters[$request->parameters[$i]] = $request->values[$i];
                    $command .= " [".$request->parameters[$i]." = ".$request->values[$i]."]";
                }
            }
        }

        try {
            Artisan::call($request->command);
            $outputs[] = Artisan::output();
            $success = true;

        } catch (\Exception $e) {
            $outputs[] = $e->getMessage();
            $success = false;
        }
        return response(['success'=>$success,'command' => $command, 'outputs' => $outputs]);
        //return view('system.index')->with('outputs',$outputs);
    }
}
