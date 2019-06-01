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
        <div class="text-center" style="padding: 10px">
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No user found</small>
        </div>
    @endif


