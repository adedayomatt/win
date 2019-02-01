{!!Form::open(['route' => ['forum.destroy',$forum->slug]])!!}
    @method('DELETE')
    {{form::submit('delete',['class'=>'btn text-danger btn-link'])}}
{!!Form::close()!!}    