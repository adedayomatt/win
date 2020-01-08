@extends('layouts.appRHSfixed')

@section('styles')
    <style>
        .experience-category-samples{
            display: flex;
            max-width: 100%;
            overflow-x:auto;
        }
        .experience-category-sample{
            width: 150px;
            height: 200px;
            margin: 0 5px;
        }
        .experience-category-sample img{
            width: 150px;
            height: 150px;
        }

    </style>
@endsection
@section('main')
    <h4>Post categories</h4>
    <?php
        // $experiencecategories = $_experienceCategories::all();
    ?>
    @if($experiencecategories->count() > 0)
        @foreach($experiencecategories as $experiencecategory)
            <a class="experience-category" href="{{route('experience.category.show',[$experiencecategory->slug])}}">{{$experiencecategory->name}}</a>
                <div class="card-body experience-category-samples">
                    @if($experiencecategory->experiences->count() > 0)
                        <?php $categoryexperiences = $experiencecategory->experiences->take(5) ?>
                        @foreach($categoryexperiences as $categoryexperience)
                        <div class="experience-category-sample border-1 ">
                                <img src="{{$categoryexperience->avatar()['src']}}" alt="{{$categoryexperience->avatar()['alt']}}">
                                <div class="p-2">
                                    {{str_limit($categoryexperience->name, 20)}}
                                    <a class="experience" href="{{route('experience',$categoryexperience->slug)}}">{{$categoryexperience->slug()}}</a>
                                </div>
                            </div> 
                        @endforeach
                    @else
                        <p class="text-center grey"><i class="fa fa-exclamtion-triangle"></i> No experience in {{$experiencecategory->name}}</p>
                    @endif
                </div>
        @endforeach
    @else
        <p class="text-danger"><i class="fa fa-exclamation-triangle"></i> No experience category found</p>
    @endif

@endsection

@section('RHS')
 @include('tag.widget')
@endsection

