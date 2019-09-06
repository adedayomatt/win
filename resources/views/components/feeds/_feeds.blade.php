@if(isset($feeds) && $feeds->count() > 0)
    <div class="infinite-scroll">
        @foreach($feeds as $feed)
            @switch($feed->type)
                @case('training')
                    @include('components.feeds.training')
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
            {{-- @if($loop->index == 3)
                @if($_comments::topContributors()->count() > 0)
                    <h6>Top Contributors</h6>
                    @include('components.owl-carousel', ['carousel_collection' => $_comments::topContributors() , 'carousel_template' => 'discussion.templates.carousel-contributor', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>3,'lg'=>3]])
                @endif
            @endif --}}

            @if($loop->index == 5)
                <h6>Recently published trainings</h6>
                @if($_trainings::count() > 0)
                    @include('components.owl-carousel', ['carousel_collection' => $_trainings::orderby('created_at', 'desc')->take(10)->get(), 'carousel_template' => 'training.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => 3, 'md' => 3, 'lg' => 3]])
                    @if($_trainings::count() > 10)
                        <div class="text-right">
                            <a href="{{route('training.index')}}">see more</a>
                        </div>
                    @endif
                @else
                    <div class="content-box text-muted text-center">
                        <small>No training found</small>
                    </div>
                @endif
            @endif
        @endforeach
        @if($feeds instanceof \Illuminate\Pagination\LengthAwarePaginator )
            {{$feeds->links()}}
        @endif
    </div>
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