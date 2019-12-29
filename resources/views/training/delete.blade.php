@extends('layouts.app')
@section('title')
   Delete {{$training->title}}
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center p-2">
                <h6>Are you sure you want to discard this training?</h6>
            </div>
            @include('training.widgets.snippet')
            <div class="content-box text-right">
                {!!Form::open(['route' => ['training.destroy',$training->id]])!!}
                    @method('DELETE')
                    <a href="{{route('training.show', [$training->slug])}}" class="btn btn-default" class="m-1">No, I'm keeping it</a>
                    {{form::submit('Yes, discard',['class'=>'btn btn-danger m-1'])}}
                {!!Form::close()!!}
            </div>
        </div>
       
    </div>
@endsection