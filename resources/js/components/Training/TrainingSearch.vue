<template>
    <div>
        <input type="search" class="training-search form-control no-outline" placeholder="search for training..."
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
       name: 'discussion-search',
        data () {
            return {
            q: '',
            suggestions: null,
            }
        },
        props: ['container'],
        computed: {
            input(){
                return `${this.container} .training-search`
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
                            url: baseURL()+'/search/training?q=%QUERY%',
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
                name: 'training-suggestions',
               
                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No training found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                    // header: '<div class="list-group-item text-center font-weight-bold">Tags Found:</div>',
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        return `<div class="list-group-item">
                                        <a href="/training/${data.slug}">
                                            <strong class="d-block">
                                                ${data.title}
                                            </strong>
                                        </a>
                                        <div class="text-muted">
                                            <small>${data.discussions_count} discussions</small>
                                        </div>
                                        <div class="text-muted">
                                            ${data.snippet}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="${data.user.image}" alt="${data.user.username}"  style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #fff">
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
            })

        }
    }
</script>
