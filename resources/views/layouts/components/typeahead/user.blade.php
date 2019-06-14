<script>
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var userTHengine = typeaheadEngine("{{route('search.user')}}")

        $('input.user-search').each(function(){
            var input = $(this);

            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: userTHengine.ttAdapter(),
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'user-suggestions',

                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No user found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var avatarURL = baseURL()+'/storage/images/users/';
                        return `<div class="list-group-item">
                                    <a href="${baseURL()}/@${data.username}">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="${data.avatar == null ? avatarURL+'default.png' : avatarURL+data.avatar}"  style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #fff">
                                            </div>
                                            <div>
                                                <strong class="d-block">${data.firstname} ${data.lastname}</strong>
                                                @${data.username}
                                            </div>
                                        </div>
                                    </a>
                                </div>`;
                }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                $(this).typeahead('val',suggestion.username)
            });
        });
    });

</script>
