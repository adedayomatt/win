<div class="dropdown">
    <a id="discussion-options" class="dropdown-toggle no-icon" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        options
    </a>
    <div class="dropdown-menu" aria-labelledby="discussion-options">
        <a href="{{route('discussion.edit',[$discussion->slug])}}" class="dropdown-item">Edit</a>
        <div class="dropdown-divider"></div>
        <a href="{{route('discussion.delete',[$discussion->slug])}}" class="dropdown-item">Delete</a>
    </div>
</div>