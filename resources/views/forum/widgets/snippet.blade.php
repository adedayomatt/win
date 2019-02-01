<div class="card">
    <div class="card-header">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4>{{$forum->name}}</h4>
                @include('forum.widgets.operations.edit')
            </div>
        </div>        
    </div>
    <div class="card-body">
        <p class="text-center">
            {!!$forum->description()!!}
        </p>
    </div>
</div>
