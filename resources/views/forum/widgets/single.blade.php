<li class="list-group-item">
    <div class="d-flex">
        <span class="bullet"></span>
        <a class="mr-2 " href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a>
        <small><span class="badge badge-secondary figure">{{$forum->discussions->count()}}</span> discussions</small>
    </div>
    <small class="grey">{!!$forum->description()!!}</small>
    <br>
    <small class="grey"><i class="fa fa-user"></i> created by {{$forum->user->fullname()}}</small>
</li>
