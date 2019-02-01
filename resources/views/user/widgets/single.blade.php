<div class="list-group-item list-group-item-action flex-column align-items-start" >
    <div class="d-flex w-100 justify-content-between">
        <div class="row align-items-center" style="width: 80%">
            <div class="col-3">
                <img src="{{$product->dp()['src']}}" alt="{{$product->dp()['alt']}}" class="dp dp-sm">
            </div>
            <div class="col-9">
                <div>
                    <strong>
                        <a href="{{route('biz.product.show',[$product->business->slug,$product->slug])}}">{{$product->name}}</a>
                    </strong>
                </div>
            </div>
        </div> 
        <small><a href="#">{{$product->category->name}}</a></small>       
    </div>
    <div class="mb-1">
        <div class="description-container">
            {!!$product->description()!!}
        </div>
</div>
    <small class="grey"><i class="fa fa-user"></i>  {{$product->business->name}} <a href="{{route('business',$product->business->slug)}}"></a>{{$product->business->slug()}}</small>
</div>