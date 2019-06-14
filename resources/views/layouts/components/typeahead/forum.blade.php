<script>
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var forumTHengine = typeaheadEngine("{{route('search.forum')}}")

        $('input.forum-search').each(function(){
            var input = $(this);

            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: forumTHengine.ttAdapter(),
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'forum-suggestions',

                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No forum found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var avatarURL = baseURL()+'/storage/images/users/';
                        return `<div class="list-group-item">
                                        <a href="{{route('forum.index')}}/${data.slug}">
                                            <strong class="d-block">
                                                ${data.name}
                                            </strong>
                                        </a>
                                        <small class="m-1">in ${data.discussions.length} discussions</small>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="${data.user.avatar == null ? avatarURL+'default.png' : avatarURL+data.user.avatar}"  style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #fff">
                                            </div>
                                            <div>
                                                <strong class="d-block">${data.user.firstname} ${data.user.lastname}</strong>
                                                <a href="${baseURL()}/@${data.user.username}">@${data.user.username}</a>
                                            </div>
                                        </div>
                                    
                                </div>`;
                }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                $(this).typeahead('val',suggestion.name)
            });
        });
    });

</script>
