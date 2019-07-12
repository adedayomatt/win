<div class="dropdown">
    <a id="discussion-options" class="dropdown-toggle no-icon" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v color-primary" style="font-size: "></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="discussion-options">
        <a href="{{route('discussion.edit',[$discussion->slug])}}" class="dropdown-item"><i class="fa fa-pen"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a href="{{route('discussion.delete',[$discussion->slug])}}" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
    </div>
</div>