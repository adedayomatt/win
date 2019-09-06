<template>
    <div id="tag-list-container" :style="container != null ? `max-height:${container}; overflow:auto` : ''">
        <div :id="id" >
            <template v-if="app_ready">
                <div v-for="tag in tags" v-bind:key="tag.id+Math.random()" class="content-box">
                    <div class="d-flex">
                        <h6><a :href="`/tag/${tag.name}`" class="tag">#{{tag.name}}</a></h6>
                        <div class="ml-auto">
                            <tag-follow-btn  v-bind:prop_tag="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed" ></tag-follow-btn>
                        </div>
                    </div>
                    <div class="text-muted">
                        Followed by: <span v-if="is_following_tag(tag)">You, </span>
                        <users :prop_users="followers(tag)"></users>
                        <div class="d-flex">
                            <small class="m-1">{{tag.discussions_count}} discussions</small>
                            <small class="m-1">{{tag.trainings_count}} trainings</small>
                        </div>
                    </div>
                </div>
            <template v-if="links != null && links.next != null">
                <div class="text-center">
                    <h1>Loading more...</h1>
                </div>
            </template>
            <template v-else>
                <div class="text-center">
                    <h1>That's all</h1>
                </div>
            </template>

            </template>
            <template v-else>
                <div class="text-center">
                    <small class="text-muted">hold on...</small>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import Users from './../User/Users';
import TagFollowButton from './TagFollowButton';

    export default {
        name: 'tag-list',
        data(){
            return {
                tags: [],
                links: null,
            }
        },
        computed: {
            ...mapGetters([
                'auth',
                'app_ready',
                'tags_following',
                'my_tags_loaded',
                'is_following_tag'
            ]),
        },
        props: [ 'id', 'container','url', 'collection'],
        methods: {
        tagFollowed(tag){
            tag.followers.push(auth())
        },
        tagUnfollowed(tag){
            removeItem(tag.followers,auth())
        },
        followers(tag){
            return tag.users;
        },
        loadTags(url){
                    axios.get(url)
                    .then(response => {
                      this.tags =  this.tags.concat(response.data.data);
                        this.links = response.data.links
                        this.loaded = true;
                        console.warn(response.data)
                    })
                    .catch(error => {

            })
        },
    },
        components: {
            TagFollowButton,Users
        },
        mounted() {
            const component = this;
            if(this.collection == null && this.url !== null){
                this.loadTags(this.url);
                let container = this.container == null ? $(window) : $('#tag-list-container');
                container.on('scroll',function(e){
                let content = $(`#tag-list-container #${component.id}`);
                console.log('content:'+content.height()+'scrolled:'+container.scrollTop());
                if(container.scrollTop() + container.height() >= content.height()){
                    if(component.links !== null && component.links.next !== null){
                        setTimeout(() => { 
                            component.loadTags(component.links.next)
                            },3000)
                        
                    }
                }
                })
            }else{
                this.tags = JSON.parse(this.collection);
            }

        }
    }
</script>
