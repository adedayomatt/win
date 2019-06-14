Tag:
<input type="text" name="tag_search" class="tag-search form-control" placeholder="search for tag..." for="selection" preview=".tags-preview">
<div class="tags-preview">
    <p id="tags-counter" class="grey">No tag selected yet</p>
</div>
@if(isset($prev_tags) && $prev_tags->count() > 0)
        <script>
            preloadTags($('.tags-preview'),@json($prev_tags));
        </script>        
    @endif

