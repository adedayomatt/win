<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;
use App\Watcher;
use App\Discussion;

class WatchController extends Controller
{
    public function watch($discussion){
		$d = Discussion::where('slug',$discussion)->first();
		if($this->isWatching($d->id,Auth::id())){
			return redirect()->route('discussion.show',['slug' => $d->slug])->with('success', 'You are already watching the discussion <strong>'.$d->title.'</strong>');
		}
		$watch = Watcher::create([
		'discussion_id' => $d->id,
		'user_id' => Auth::id()
		]);
		return redirect()->route('discussion.show',['slug' => $d->slug])->with('success', 'You are now watching the discussion <strong>'.$d->title.'</strong>');
	}
    public function unwatch($discussion){
		$d = Discussion::where('slug',$discussion)->first();
		if(!$this->isWatching($d->id,Auth::id())){
			return redirect()->route('discussion.show',['slug' => $d->slug])->with('success', 'You were not watching the discussion <strong>'.$d->title.'</strong> before');
		}
		Watcher::where('discussion_id',$d->id)->where('user_id', Auth::id())->delete();
		return redirect()->route('discussion.show',['slug' => $d->slug])->with('success', 'You are no longer watching the discussion <strong>'.$d->title.'</strong>');
	}
	
	public function isWatching($discussion,$user){
		if(Watcher::where('discussion_id',$discussion)->where('user_id', $user)->count() > 0){
			return true;
		}
		return false;
	}
}
