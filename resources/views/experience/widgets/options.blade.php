<div class="dropdown">
    <a id="experience-options" class="dropdown-toggle no-icon" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v color-primary" style="font-size: "></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="experience-options">
        <a href="{{route('experience.edit',[$experience->slug])}}" class="dropdown-item"><i class="fa fa-pen"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a href="{{route('experience.delete',[$experience->slug])}}" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
    </div>
</div>