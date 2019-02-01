Tag:
<input type="text" name="tag_search" class="tag-search form-control" placeholder="search for tag..." create="tags" preview=".tags-preview">
<div class="tags-preview">
    <p id="tags-counter" class="grey">No tag selected yet</p>
</div>
@if(isset($prevTags) && $prevTags->count() > 0)
        <script>
            @foreach($prevTags as $pt)
                addTag($('.tags-preview'),@json($pt));
            @endforeach
        </script>        
    @endif

