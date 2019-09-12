<div class="dropdown">
    <a id="training-options" class="dropdown-toggle no-icon" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v color-primary" style="font-size: "></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="training-options">
        <a href="{{route('training.edit',[$training->slug])}}" class="dropdown-item"><i class="fa fa-pen"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a href="{{route('training.delete',[$training->slug])}}" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
    </div>
</div>