@extends('layouts.appRHSfixed')

@section('styles')
    <style>
        .training-category-samples{
            display: flex;
            max-width: 100%;
            overflow-x:auto;
        }
        .training-category-sample{
            width: 150px;
            height: 200px;
            margin: 0 5px;
        }
        .training-category-sample img{
            width: 150px;
            height: 150px;
        }

    </style>
@endsection
@section('main')
    <h4>Post categories</h4>
    <?php
        // $trainingcategories = $_trainingCategories::all();
    ?>
    @if($trainingcategories->count() > 0)
        @foreach($trainingcategories as $trainingcategory)
            <a class="training-category" href="{{route('training.category.show',[$trainingcategory->slug])}}">{{$trainingcategory->name}}</a>
                <div class="card-body training-category-samples">
                    @if($trainingcategory->trainings->count() > 0)
                        <?php $categorytrainings = $trainingcategory->trainings->take(5) ?>
                        @foreach($categorytrainings as $categorytraining)
                        <div class="training-category-sample border-1 ">
                                <img src="{{$categorytraining->avatar()['src']}}" alt="{{$categorytraining->avatar()['alt']}}">
                                <div class="p-2">
                                    {{str_limit($categorytraining->name, 20)}}
                                    <a class="training" href="{{route('training',$categorytraining->slug)}}">{{$categorytraining->slug()}}</a>
                                </div>
                            </div> 
                        @endforeach
                    @else
                        <p class="text-center grey"><i class="fa fa-exclamtion-triangle"></i> No training in {{$trainingcategory->name}}</p>
                    @endif
                </div>
        @endforeach
    @else
        <p class="text-danger"><i class="fa fa-exclamation-triangle"></i> No training category found</p>
    @endif

@endsection

@section('RHS')
 @include('tag.widget')
@endsection

