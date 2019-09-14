<?php 
    $tags_collection = isset($tags) ? $tags : \App\Tag::recent();
?>
<tags collection="{{$tags_collection}}" id="side-tags" type="list"></tags>

