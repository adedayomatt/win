<script>
    SELECTED_TAGS = [];
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var tagTHengine = typeaheadEngine("{{route('search.tag')}}")

        $('input.tag-search').each(function(){
            var input = $(this);
            

            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: tagTHengine.ttAdapter(),
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'tag-suggestions',

                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No tag found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var followers = "";
                        if(data.users.length > 0){
                            var avatarURL = baseURL()+'/storage/images/users/';
                            followers = `<div class="text-muted">`;
                            for(var user of data.users.slice(0,5)){
                                 followers += `<img src="${user.avatar == null ? avatarURL+'default.png' : avatarURL+user.avatar}"  style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px; border: 2px solid #fff" data-toggle="tooltip" title="@${user.username}">`;
                            }
                            followers += `</div>`;
                        }
                        switch(input.attr('for')){
                            
                            case 'selection':
                                    return `<div class="list-group-item ${tagSelected(data) ? 'bg-primary' : ''}">
                                            <div class="d-flex">
                                                <div>
                                                    <strong class="d-block">
                                                        <a href="{{route('tag.index')}}/${data.name}">${data.name}</a>
                                                    </strong>
                                                    <div class="text-muted">
                                                        <small class="m-1">
                                                            ${data.experiences.length} experiences</a>
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.discussions.length} discussions
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.users.length} followers
                                                        </small>
                                                    </div>
                                                    ${followers}
                                                </div>
                                                <div class="ml-auto">
                                                    <small class="btn btn-sm btn-theme">${tagSelected(data) ? 'selected' : 'select'}</small>
                                                </div>
                                            </div>
                                        </div>`;
                            break;

                            default:
                            return `<div class="list-group-item">
                                            <div class="d-flex">
                                                <div>
                                                    <strong class="d-block">
                                                        <a href="{{route('tag.index')}}/${data.name}">${data.name}</a>
                                                    </strong>
                                                    <div class="text-muted">
                                                        <small class="m-1">
                                                            ${data.experiences.length} experiences</a>
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.discussions.length} discussions
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.users.length} followers
                                                        </small>
                                                    </div>
                                                    ${followers}
                                                </div>
                        
                                            </div>
                                        </div>`;
                            break;
                        }
                }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                if($(this).attr('for') && $(this).attr('preview') && !tagSelected(suggestion)){ //suggesting for a new experience
                    $(this).typeahead('val',''); //clear the values
                    var tagsPreview = $($(this).attr('preview'));
                    addTag(tagsPreview,suggestion)
                }
            else{
                    $(this).typeahead('val',suggestion.name)
            }
            });
        });
    });


        function addTag(container,tag){
            if(!tagSelected(tag)){ //if not selected before
                var tagID = 'tag-'+tag.name+'-'+tag.id;
                var tagContainer = $('<span>').attr({
                    class: 'tag',
                    id: tagID
                });
                
                var tagInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'tags[]',
                    value: tag.id
                });


                var tagElement = $('<span>').attr({
                    class: '',
                }).text(tag.name);

                var tagRemover = $('<span>').attr({
                    class: 'float-right closer',
                    remove: tagID
                }).html('&times');
                

                tagContainer.append(tagElement,tagRemover,tagInput);
                container.append(tagContainer);
                SELECTED_TAGS.push(tag.id);

                container.on('click', '[remove = "'+tagID+'"]', function(e){
                container.find('#'+tagID).remove();
                SELECTED_TAGS.splice(SELECTED_TAGS.indexOf(tag.id),1); //remove the id from the selected
                container.find('#tags-counter').text(SELECTED_TAGS.length+' tag'+(SELECTED_TAGS.length > 1 ? 's' : '')+' selected');
            });           
            container.find('#tags-counter').text(SELECTED_TAGS.length+' tag'+(SELECTED_TAGS.length > 1 ? 's' : '')+' selected');
            return true;
            }
            return false;

    }
    function preloadTags(container, tags){
        for(var tag of tags){
            addTag(container,tag);
        }
    }
    function tagSelected(tag){ //check if a tag is already selected
        return SELECTED_TAGS.indexOf(tag.id) < 0 ? false : true;
    }
</script>
