<?php
    $collection = isset($users_collection) ? $users_collection: $_users::all();
?>

    @if($collection->count() >0 )
        @foreach($collection as $user)
        <div class="py-1">
        @include('user.widgets.snippet', ['user' => $user])
        </div> 
        @endforeach
    @else
        <div class="content-box text-muted text-center">
            <small> No user found</small>
        </div>
    @endif


