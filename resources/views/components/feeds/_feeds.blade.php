@if(isset($feeds) && $feeds->count() > 0)
    @foreach($feeds as $feed)
        @switch($feed->type())
            @case('post')
                @include('components.feeds.post')
            @break
            @case('comment')
                @include('components.feeds.comment')
            @break
            @case('discussion')
                @include('components.feeds.discussion')
            @break


        @endswitch
    @endforeach
@else
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="grey py-5">
                @auth()
                    <h5>There is nothing in your feed for now</h5> 
                    <p>You are currently following {{auth()->user()->tags->count()}} tags <a href="{{route('edit.interests',auth()->user()->username)}}">update now</a></p>
                @endauth

                @guest()
                    <h5>We don't have much to show you here</h5> 
                @endguest
            </div>
        </div>
    </div>
@endif