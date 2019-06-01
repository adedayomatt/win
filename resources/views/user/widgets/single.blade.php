<div class="list-group-item list-group-item-action flex-column align-items-start" >
    <div class="d-flex w-100 justify-content-between">
        <div class="row align-items-center" style="width: 80%">
            <div class="col-3">
                <img src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}" class="avatar avatar-sm">
            </div>
            <div class="col-9">
                <div>
                    <strong>
                        <a href="{{route('user.profile',[$user->username()])}}">{{$user->fullname()}}</a>
                    </strong>
                </div>
            </div>
        </div> 
            
    </div>        
</div>
