<?php 
    $experiencecategories = $_experienceCategories::all();
?>
<div class="card widget">
    <div class="card-header">
        <h5>Post Categories</h5>
        <form action="">
            <input class="form-control" type="text" placeholder="search for experience category...">
        </form>
    </div>
    <div class="card-body">
        <ul class="list-group ball-bullet">
            @if($experiencecategories->count() > 0)
                @foreach($experiencecategories as $experiencecategory)
                    <li class="list-group-item">
                        <div class="d-flex">
                            <span class="bullet"></span>
                            <a class="experience-category mr-2 " href="{{route('experience.category.show',[$experiencecategory->slug])}}">{{ $experiencecategory->name}}</a>
                            <small><span class="badge badge-secondary figure">{{$experiencecategory->experiences->count()}}</span> experiences</small>
                        </div>
                       <small>{!!$experiencecategory->description()!!}</small>
                    </li>
                @endforeach
                <div class="text-right">
                    <a href="{{route('experience.categories')}}">see all categories</a>
                </div>
            @else
                <li class="list-group-item">
                    <small class="text-danger">No category found</small>
                </li>
            @endif
        </ul> 
    </div>
</div>
