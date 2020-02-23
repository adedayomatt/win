<script>
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var experienceTHengine = typeaheadEngine("{{route('search.experience')}}")

        $('input.experience-search').each(function(){
            var input = $(this);

            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: experienceTHengine.ttAdapter(),
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'experience-suggestions',

                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No experience found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var avatarURL = baseURL()+'/storage/images/users/';
                        return `<div class="list-group-item">
                                        <a href="{{route('experience.index')}}/${data.slug}">
                                            <strong class="d-block">
                                                ${data.title}
                                            </strong>
                                        </a>
                                        <div class="text-muted">
                                            <small>${data.discussions.length} discussions</small>
                                        </div>
                                        <div class="text-muted">
                                            ${data.content.substring(0,200)}
                                        </div>
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
                $(this).typeahead('val',suggestion.title)
            });
        });
    });

</script>