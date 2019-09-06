<template>
    <div id="tag-selection">
        <tag-search container="#tag-selection" purpose="follow" key="2"></tag-search>
        <div class="row">
            <div class="col-md-6">
                <strong>Already following</strong>
                <div>
                    <small class="text-muted">Following {{tags_following.length}} tags</small>
                </div>
                <div class="list-group" style="max-height: 300px; overflow: auto">
                    <div class="list-group-item" v-for="tag in tags_following" v-bind:key="tag.id">
                        <div class="d-flex p-1">
                            <div>
                                <a class="tag d-block" href="/tag/">#{{tag.name}}</a>
                            </div>
                            <div class="ml-auto mr-1">
                                <tag-follow-btn  v-bind:prop_tag="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed" ></tag-follow-btn>
                            </div>
                        </div>
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
                            <div class="d-flex p-1">
                                <div>
                                    <a class="tag d-block" href="/tag/">#{{tag.name}}</a>
                                </div>
                                <div class="ml-auto mr-1">
                                    <tag-follow-btn  v-bind:prop_tag="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed" ></tag-follow-btn>
                                </div>
                            </div>
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

import TagSearch from './TagSearch.vue';
import TagFollowButton from './TagFollowButton.vue';

export default {
    name: 'tag-suggest',
    data(){
        return {
            suggested_tag_status: 'loading my suggestions...',
            suggestions: [],
        }
    },
    props: [],
     computed: {
        ...mapGetters([
            'app_ready',
            'tags_following',
            'is_following_tag'
        ])
    },
    methods: {
        ...mapActions([
            'loadSuggestionTags'
        ]),
        tagFollowed(tag){
            //console.log(`now following ${tag.name}`);
            //this.$store.commit('ADD_TAG', tag);
        },
        tagUnfollowed(tag){
           // console.log(`now unfollowing ${tag.name}`);
            //this.$store.commit('REMOVE_TAG', tag);
        }       
    },
    mounted() {
        this.loadSuggestionTags()
        .then(response => {
            console.log(response.data);
            this.suggestions = response.data;
            this.suggested_tag_status =`${response.data.length} suggestions`
        })
        .catch(error => {
            this.suggested_tag_status =`Failed to load suggestions: ${error.response.statusText}`
        })
    },
    components: {
        TagSearch,TagFollowButton
    }
}
</script>