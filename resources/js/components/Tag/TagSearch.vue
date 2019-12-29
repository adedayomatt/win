<template>
    <div>
        <input type="search" class="tag-search form-control no-outline" placeholder="search for tag..."
        v-model.trim="q"
        >
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import Bloodhound from 'corejs-typeahead/dist/bloodhound';
    import typeahead from 'corejs-typeahead/dist/typeahead.jquery';

    import TagFollowButton from './TagFollowButton.vue';

    export default {
       name: 'search',
        data () {
            return {
            q: '',
            tags_following: [],
            suggestions: null,
            selected: this.already_selected
            }
        },
        props: ['container','purpose', 'already_selected'],
        computed: {
           
            input(){
                return `${this.container} .tag-search`
            }, 
            // check if this component is for tag selection
            isForSelection(){
                return this.purpose === 'selection' ? true : false;
            },
            isForFollow(){
                return this.purpose === 'follow' ? true : false;
            },

        },
        methods: {
            ...mapActions([
            'getAuth',
            'loadMyTags',
            'followTag',
            'createNewTag'
            ]),

            select(tag){
                this.selected.push(tag);
                this.$emit('tag-selected', tag);
                $(this.input).typeahead('val','');
            },
            follow(tag){
                this.followTag(tag)
                .then(response => {
                    this.tags_following.push(response.data.tag);
                    this.$emit('tag-followed', response.data.tag)
                })
                .catch(error =>{

                })
            },
            isSelected(tag){
               return itemExist(this.selected, tag);
            },
            isFollowing(tag){
               return itemExist(this.tags_following, tag);
            }
            
        },
        components: {
            TagFollowButton
        },
        mounted() {
            this.loadMyTags()
            .then(response => {
                this.tags_following = response.data;
            })
            .catch(error => {

            })
            let component = this;
            this.suggestions = new Bloodhound({
				remote: {
                            url: baseURL()+'/search/tag?q=%QUERY%',
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
                name: 'tag-suggestions',

                templates: {
                    empty : '<div class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i> No tag found</div>',
                    pending: '<div class="list-group-item text-center">searching...</div>',
                     empty : function(){
                        if(component.isForSelection){
                            return `<div class="list-group-item new-tag"><strong>"${input.typeahead('val')}"</strong></div>`;
                        }
                    },
                    pending: function(){
                        if(component.isForSelection){
                            return `<div class="list-group-item new-tag"><strong>"${input.typeahead('val')}"</strong></div>`;
                        }
                    },
                    header: function(){
                        if(component.isForSelection){
                            return `<div class="list-group-item new-tag"><strong>"${input.typeahead('val')}"</strong></div>`;
                        }
                    },
                    suggestion: function (data) {
                        var followers = "";
                        if(data.users.length > 0){
                            followers = `<div class="text-muted">`;
                            for(var user of data.users.slice(0,5)){
                                 followers += `<img src="${user.image.src}"  style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px; border: 2px solid #fff" data-toggle="tooltip" title="@${user.username}">`;
                            }
                            followers += `</div>`;
                        }
                        switch(component.purpose){
                            
                            case 'selection':
                                    return `<div class="list-group-item ${component.isSelected(data) ? 'bg-primary text-light' : ''}">
                                            <div class="d-flex">
                                                <div>
                                                    <strong class="d-block">
                                                        <strong>${data.name}</strong>
                                                    </strong>
                                                    <div class="text-muted">
                                                        <small class="m-1">
                                                            ${data.trainings_count} trainings</a>
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.discussions_count} discussions
                                                        </small>
                                                        <small class="m-1">
                                                            ${data.users.length} followers
                                                        </small>
                                                    </div>
                                                    ${followers}
                                                </div>
                                                <div class="ml-auto">
                                                    <small class="text-muted">${component.isSelected(data) ? 'already selected' : ''}</small>
                                                </div>
                                            </div>
                                        </div>`;
                            break;

                            case 'follow':
                                    return `<div class="list-group-item">
                                                <div class="d-flex">
                                                    <div>
                                                        <strong class="d-block">
                                                            <strong>${data.name}</strong>
                                                        </strong>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <small>${component.isFollowing(data) ? 'already following' : 'select to follow'}</small>
                                                    </div>
                                                </div>
                                                <div class="text-muted">
                                                    <small class="m-1">
                                                        ${data.trainings_count} trainings</a>
                                                    </small>
                                                    <small class="m-1">
                                                        ${data.discussions_count} discussions
                                                    </small>
                                                    <small class="m-1">
                                                        ${data.users.length} followers
                                                    </small>
                                                </div>
                                                ${followers}
                                                <div class="ml-auto">
                                                    <small class="text-muted">${component.isFollowing(data) ? 'Already following' : ''}</small>
                                                </div>
                                            </div>`;
                            break;

                            default:
                            return `<div class="list-group-item">
                                           
                                                <div class="d-flex">
                                                    <strong class="d-block">
                                                        <a href="/tag/${data.name}">${data.name}</a>
                                                    </strong>
                                                    <div class="ml-auto">
                                                        <small>${component.isFollowing(data) ? 'following' : ''}</small>
                                                    </div>

                                                </div>
                                                <div class="text-muted">
                                                    <small class="m-1">
                                                        ${data.trainings_count} trainings</a>
                                                    </small>
                                                    <small class="m-1">
                                                        ${data.discussions_count} discussions
                                                    </small>
                                                    <small class="m-1">
                                                        ${data.users.length} followers
                                                    </small>
                                                </div>
                                                    ${followers}
                        
                                            </div>
                                        </div>`;
                            break;
                        }
                }
                }
            });

            // create a new tag from what the user typed
            $(this.container).on('click', '.new-tag', function(e){
                component.createNewTag($(this).text())
                .then(response => {
                    component.select(response.data.data);
                })
                .catch(error => {

                })
            })

            $(this.input).on('typeahead:beforeselect', function(ev, suggestion) {
                // if(component.isForFollow || component.isForFollow){
                //     ev.preventDefault();
                // }
            });

            $(this.input).on('typeahead:select', function(ev, suggestion) {
                $(this).typeahead('val',suggestion.name);
                if(component.isForSelection){
                    component.select(suggestion);
                }
                else if(component.isForFollow){
                    component.follow(suggestion)
                }
            });
        }
    }
</script>
