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
        @if(($loop->index)%5 == 0)
           @include('components.ads.sample')
        @endif
    @endforeach
@else
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="grey py-5">
                @auth()
                    <h5>There is nothing in this feed for now</h5> 
                @endauth

                @guest()
                    <h5>We don't have much to show you here</h5> 
                @endguest
            </div>
        </div>
    </div>
@endif