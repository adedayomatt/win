{!!Form::open(['route' => ['biz.product.destroy',auth('vendor')->user()->business->slug,$product->slug]])!!}
    @method('DELETE')
    {{form::submit('delete',['class'=>'btn text-danger btn-link'])}}
{!!Form::close()!!}    