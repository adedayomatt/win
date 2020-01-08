<template>
    <div id="tag-selection">
        <tag-search container="#tag-selection" purpose="follow" key="2" @tag-followed="tagFollowed"></tag-search>
        <div class="row">
            <div class="col-md-6">
                <strong>Already following</strong>
                <div>
                    <small class="text-muted">Following {{tags_following.length}} tags</small>
                </div>
                <div class="list-group" style="max-height: 300px; overflow: auto">
                    <div class="list-group-item" v-for="tag in tags_following" v-bind:key="tag.id">
                        <tag :data="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed"></tag>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <strong>Suggestions</strong>
                <div>
                    <small class="text-muted">{{suggested_tag_status}}</small>
                </div>
                <template v-if="app_ready">
                    <div class="list-group" style="max-height: 300px; overflow: auto">
                        <div class="list-group-item" v-for="tag in suggestions" v-bind:key="tag.id+Math.random()">
                            <tag :data="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed"></tag>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

import Tag from './Tag.vue';
import TagSearch from './TagSearch.vue';

export default {
    name: 'tag-suggest',
    data(){
        return {
            tags_following: [],
            suggested_tag_status: 'loading my suggestions...',
            suggestions: [],
        }
    },
    props: [],
     computed: {
        ...mapGetters([
            'app_ready',
        ])
    },
    methods: {
        ...mapActions([
            'loadMyTags',
            'loadSuggestionTags'
        ]),
        tagFollowed(tag){
            this.tags_following.push(tag)
        },
        tagUnfollowed(tag){
            this.tags_following.splice(getIndex(this.tags_following,tag),1)
        },  
      

    },
    mounted() {
        this.loadMyTags()
        .then(response => {
            this.tags_following = response.data;
            this.loadSuggestionTags()
            .then(response => {
                console.log(response.data);
                this.suggestions = response.data;
                this.suggested_tag_status =`${response.data.length} suggestions`
            })
            .catch(error => {
                this.suggested_tag_status =`Failed to load suggestions: ${error.response.statusText}`
            })
        })
        .catch(error => {
           
        })
        
    },
    components: {
        TagSearch,Tag
    }
}
</script>