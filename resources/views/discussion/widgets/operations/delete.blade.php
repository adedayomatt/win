{!!Form::open(['route' => ['discussion.destroy',$post->slug]])!!}
    @method('DELETE')
    {{form::submit('delete',['class'=>'btn text-danger btn-link'])}}
{!!Form::close()!!}    