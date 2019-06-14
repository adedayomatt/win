<?php 
    $trainingcategories = $_trainingCategories::all();
?>
<div class="card widget">
    <div class="card-header">
        <h5>Post Categories</h5>
        <form action="">
            <input class="form-control" type="text" placeholder="search for training category...">
        </form>
    </div>
    <div class="card-body">
        <ul class="list-group ball-bullet">
            @if($trainingcategories->count() > 0)
                @foreach($trainingcategories as $trainingcategory)
                    <li class="list-group-item">
                        <div class="d-flex">
                            <span class="bullet"></span>
                            <a class="training-category mr-2 " href="{{route('training.category.show',[$trainingcategory->slug])}}">{{ $trainingcategory->name}}</a>
                            <small><span class="badge badge-secondary figure">{{$trainingcategory->trainings->count()}}</span> trainings</small>
                        </div>
                       <small>{!!$trainingcategory->description()!!}</small>
                    </li>
                @endforeach
                <div class="text-right">
                    <a href="{{route('training.categories')}}">see all categories</a>
                </div>
            @else
                <li class="list-group-item">
                    <small class="text-danger">No category found</small>
                </li>
            @endif
        </ul> 
    </div>
</div>
