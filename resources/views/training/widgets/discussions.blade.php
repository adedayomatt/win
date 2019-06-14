<?php $discussions = $training->discussions()->orderby('created_at','desc')->paginate(config('app.pagination')) ?>
@if($discussions->count() > 0)
    <div class="infinite-scroll">
        @foreach($discussions as $discussion)
            <div class="snippet">
                <strong><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></strong>
                <div class="pl-2">
                    @include('discussion.widgets.meta')
                </div>
                {!!$discussion->content()!!} 
                <a href="{{route('discussion.show',[$discussion->slug])}}">see full discussion</a>
                @include('tag.widgets.inline', ['tags' => $discussion->tags])
                <div style="border-top: 1px solid #f2f2f2" class="pt-1 d-flex">
                    <div class="pl-2">
                        <span class="small text-muted mr-2">participating: </span>
                        @include('discussion.widgets.contributors-mini',['discussion' => $discussion])
                    </div>
                </div>
            </div>
        @endforeach
        {{$discussions->links()}}
    </div>
@else
    <div class="content-box text-center text-muted">
            <small >
                No discussion on <strong>{{$training->title}}</strong> yet
            </small>
    </div>
@endif

