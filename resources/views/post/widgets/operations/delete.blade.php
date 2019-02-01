{!!Form::open(['route' => ['post.destroy',$post->slug]])!!}
    @method('DELETE')
    {{form::submit('delete',['class'=>'btn text-danger btn-link'])}}
{!!Form::close()!!}    