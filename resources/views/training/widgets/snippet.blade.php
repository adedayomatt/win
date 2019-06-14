@if($training->isTrashed())
    <div class="content-box text-muted" data-toggle="tooltip" title="training deleted">
        <strong class="d-block">{{$discussion->training()->title}}</strong>
        <small>{!!$discussion->training()->content()!!}</small>
    </div>
@else
<div class="snippet row row-eq-height">
    <div class="col-4" style="background-image: url('{{$training->cover()['src']}}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        <img class="d-none" src="{{$training->cover()['src']}}" alt="{{$training->cover()['alt']}}" width="100%">
    </div>
    <div class="col-8">
        <div class="float-right bg-primary  py-1 px-2 small" style="color:#fff">training</div>
        <div class="card-title">
            <div>
                <a href="{{route('training.show',$training->slug)}}"><strong>{{$training->title}}</strong></a>
                <div class="ml-2">
                @include('training.widgets.meta')
                </div>
            </div>
        </div>
        {!!$training->content()!!} 
    </div>
    @include('tag.widgets.inline',['tags'=> $training->tags])
</div>
@endif