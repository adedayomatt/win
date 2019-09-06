<?php 
    $tags_collection = isset($tags) ? $tags : $_tags::orderby('name','asc')->take(10)->get();
?>
<tags collection="{{$tags_collection}}" id="side-tags" type="list"></tags>

