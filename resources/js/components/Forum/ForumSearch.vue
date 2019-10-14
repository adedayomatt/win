<template>
    <div>
        <input type="search" class="forum-search form-control no-outline" placeholder="search for forum..."
        v-model.trim="q"
        >
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import Bloodhound from 'corejs-typeahead/dist/bloodhound';
    import typeahead from 'corejs-typeahead/dist/typeahead.jquery';


    export default {
       name: 'forum-search',
        data () {
            return {
            q: '',
            suggestions: null,
            }
        },
        props: ['container'],
        computed: {
            input(){
                return `${this.container} .forum-search`
            }, 
           
        },
        methods: {
            
        },
        components: {
        
        },
        mounted() {
            let component = this;
            this.suggestions = new Bloodhound({
				remote: {
                            url: baseURL()+'/search/forum?q=%QUERY%',
                            wildcard: '%QUERY%'
                        },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
                });
            let input = $(this.input);
            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: this.suggestions,
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'forum-suggestions',
                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No forum found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        return `<div class="list-group-item">
                                        <a href="/forum/${data.slug}">
                                            <strong class="d-block">
                                                ${data.name}
                                            </strong>
                                        </a>
                                        <small class="m-1">in ${data.discussions_count} discussions</small>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="${data.user.image.src}" alt="${data.user.username}" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #fff">
                                            </div>
                                            <div>
                                                <strong class="d-block">${data.user.fullname}</strong>
                                                <a href="${baseURL()}/@${data.user.username}">@${data.user.username}</a>
                                            </div>
                                        </div>
                                    
                                </div>`;
                }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                $(this).typeahead('val',suggestion.name)
            })

        }
    }
</script>
