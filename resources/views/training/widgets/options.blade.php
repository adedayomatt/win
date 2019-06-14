<div class="dropdown">
    <a id="training-options" class="dropdown-toggle no-icon" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        options
    </a>
    <div class="dropdown-menu" aria-labelledby="training-options">
        <a href="{{route('training.edit',[$training->slug])}}" class="dropdown-item">Edit</a>
        <div class="dropdown-divider"></div>
        <a href="{{route('training.delete',[$training->slug])}}" class="dropdown-item">Delete</a>
    </div>
</div>