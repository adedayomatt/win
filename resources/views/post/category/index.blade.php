@extends('layouts.appRHSfixed')

@section('styles')
    <style>
        .post-category-samples{
            display: flex;
            max-width: 100%;
            overflow-x:auto;
        }
        .post-category-sample{
            width: 150px;
            height: 200px;
            margin: 0 5px;
        }
        .post-category-sample img{
            width: 150px;
            height: 150px;
        }

    </style>
@endsection
@section('main')
    <h4>Post categories</h4>
    <?php
        // $postcategories = $_postCategories::all();
    ?>
    @if($postcategories->count() > 0)
        @foreach($postcategories as $postcategory)
            <a class="post-category" href="{{route('post.category.show',[$postcategory->slug])}}">{{$postcategory->name}}</a>
                <div class="card-body post-category-samples">
                    @if($postcategory->posts->count() > 0)
                        <?php $categoryposts = $postcategory->posts->take(5) ?>
                        @foreach($categoryposts as $categorypost)
                        <div class="post-category-sample border-1 ">
                                <img src="{{$categorypost->avatar()['src']}}" alt="{{$categorypost->avatar()['alt']}}">
                                <div class="p-2">
                                    {{str_limit($categorypost->name, 20)}}
                                    <a class="post" href="{{route('post',$categorypost->slug)}}">{{$categorypost->slug()}}</a>
                                </div>
                            </div> 
                        @endforeach
                    @else
                        <p class="text-center grey"><i class="fa fa-exclamtion-triangle"></i> No post in {{$postcategory->name}}</p>
                    @endif
                </div>
        @endforeach
    @else
        <p class="text-danger"><i class="fa fa-exclamation-triangle"></i> No post category found</p>
    @endif

@endsection

@section('RHS')
 @include('tag.widget')
@endsection

