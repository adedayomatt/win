<li class="list-group-item border-0" >
    <div class="d-flex">
        <span class="icon mr-2"><i class="fas fa-comments"></i></span>

        <p>
            <a class="mr-2 discussion" href="{{route('discussion.show',[$discussion->slug])}}"><strong>{{ $discussion->title}}</strong></a>
            @if($discussion->fromPost())
                on the post <a href="{{route('post.show',$discussion->post->slug)}}"><strong>  {{$discussion->post->title}}</strong></a>
            @endif            
        </p> 
 
    </div>
    <div class="pl-3">
        @include('discussion.widgets.meta')
    </div>
    {!!$discussion->content()!!}
    <?php $tags = $discussion->tags ?>
        @include('tag.widget-alt')

</li>
