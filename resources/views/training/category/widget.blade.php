<?php 
    $postcategories = $_postCategories::all();
?>
<div class="card widget">
    <div class="card-header">
        <h5>Post Categories</h5>
        <form action="">
            <input class="form-control" type="text" placeholder="search for post category...">
        </form>
    </div>
    <div class="card-body">
        <ul class="list-group ball-bullet">
            @if($postcategories->count() > 0)
                @foreach($postcategories as $postcategory)
                    <li class="list-group-item">
                        <div class="d-flex">
                            <span class="bullet"></span>
                            <a class="post-category mr-2 " href="{{route('post.category.show',[$postcategory->slug])}}">{{ $postcategory->name}}</a>
                            <small><span class="badge badge-secondary figure">{{$postcategory->posts->count()}}</span> posts</small>
                        </div>
                       <small class="grey">{!!$postcategory->description()!!}</small>
                    </li>
                @endforeach
                <div class="text-right">
                    <a href="{{route('post.categories')}}">see all categories</a>
                </div>
            @else
                <li class="list-group-item">
                    <small class="text-danger">No category found</small>
                </li>
            @endif
        </ul> 
    </div>
</div>
