<script>
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var schoolTHengine = typeaheadEngine("{{route('search.school')}}")

        $('.school-selection').each(function(){
            var container = $(this);
            var input = $(this).find('input.school-search');
            var value = "";
            input.bind('keyup', function(e){
                value = $(this).val();
            })
            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: schoolTHengine.ttAdapter(),
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'school-suggestions',

                templates: {
                    empty : function(){
                        return `<div class="list-group-item"><strong>"${input.typeahead('val')}"</strong></div>`
                    },
                    pending: function(){
                        return `<div class="list-group-item"><strong>"${input.typeahead('val')}"</strong></div>`
                    },
                    header: function(){
                        return `<div class="list-group-item"><strong>"${input.typeahead('val')}"</strong></div>`
                    },
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var avatarURL = baseURL()+'/storage/images/users/';
                        return `<div class="list-group-item">
                                        <strong class="d-block">
                                            ${data.name}
                                        </strong>
                                        <small class="m-1 d-block">${data.address == null ? '' : data.address}</small>
                                        ${data.educations != null ? '<small class="m-1 d-block"> '+data.educations.length+' others attends</small>' : ''}
                                </div>`;
                    }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                input.typeahead('val',suggestion.name);
                container.find('[name="school_id"]').val(suggestion.id);
            })
        });
    });

</script>
