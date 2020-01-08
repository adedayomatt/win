@extends('layouts.app')
@section('title')
   Delete {{$experience->title}}
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center p-2">
                <h6>Are you sure you want to discard this experience?</h6>
            </div>
            @include('experience.widgets.snippet')
            <div class="content-box text-right">
                {!!Form::open(['route' => ['experience.destroy',$experience->id]])!!}
                    @method('DELETE')
                    <a href="{{route('experience.show', [$experience->slug])}}" class="btn btn-default" class="m-1">No, I'm keeping it</a>
                    {{form::submit('Yes, discard',['class'=>'btn btn-danger m-1'])}}
                {!!Form::close()!!}
            </div>
        </div>
       
    </div>
@endsection