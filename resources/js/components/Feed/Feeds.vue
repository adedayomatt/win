<template>
    <div>
         <template v-if="mode === 'single'">
             <div class="blur"></div>
            <div class="single-feed-container shadow-lg">
                <comment-popup :data="single_comment" :id="single_comment_id" @close-popup="closeSingleFeed"></comment-popup>
            </div>
        </template>
        <div id="feeds-container" :style="`${container !== null ? 'max-height: '+container+'; overflow-y: auto' : ''}`">
            <div id="feeds-wrapper">
                <template v-if="loaded">
                    <template v-if="feeds.length == 0">
                        <div class="text-muted text-center">
                            <p>There is nothing in this feed yet</p>
                        </div>
                    </template>
                    <template v-else>
                        <div>
                            <div v-for="feed in computedFeeds" :key="generateKey(feed)">
                                <div>
                                    <template  v-if="feed.type == 'comment'">
                                        <div>
                                            <comment :data="feed"  @load-single-comment-by-data="loadSingleCommentByData" @load-single-comment-by-id="loadSingleCommentById" :quote_discussion="true" :quote_comment="true"></comment>
                                        </div>
                                    </template>
                                    <template v-else-if="feed.type == 'discussion'">
                                        <discussion  :data="feed"></discussion>
                                    </template>
                                    <template v-else-if="feed.type == 'experience'" >
                                        <experience :data="feed"></experience>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <template v-if="links !== null && links.next !== null">
                            <div id="more-feeds-loader">
                                <loading-one message="loading more feeds..."  :error="feeds_loading_error" @retry="getNextFeeds"></loading-one>
                            </div>
                        </template>
                        <template v-else>
                            <div class="text-center">
                                <h1>.</h1>
                            </div>
                        </template>
                    </template>
                </template>
                <template v-else>
                    <loading-one message="loading feeds..." :error="feeds_loading_error" @retry="getFeeds"></loading-one>
                </template>
            </div>
        </div>


    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import CommentFeed from './CommentFeed'
import DiscussionFeed from './DiscussionFeed'
import ExperienceFeed from './ExperienceFeed'
import LoadingOne from './../Assets/LoadingOne'

export default {
        data(){
            return {
               key: 1,
               feeds: [],
               links: null,
               meta: null,
               mode: 'feeds',
               loaded: false,
               can_load_more: true,
               single_comment: null,
               single_comment_id: null,
               single_discussion: null,
               single_experience: null,
               feeds_loading_error: null,
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'time_diff',
                'snippet',
                'is_trashed'
            ]),
            computedFeeds(){
                return this.feeds;
            }
            
        },
        props: ['container', 'url'],
        methods:{
            ...mapActions([

            ]),

            loadFeeds(url){
                this.feeds_loading_error = null;
                this.can_load_more = false; //disallow loading more while this request is processing
                axios.get(url)
                .then(response => { 
                    this.feeds = this.feeds.concat(response.data.data);
                    this.links = response.data.links;
                    this.meta = response.data.meta;
                    this.loaded = true;
                    this.can_load_more = true;
                    // console.warn(response.data.data);
                })
                .catch(error => {
                    this.feeds_loading_error = error;
                })
            },
            getFeeds(){
                this.loadFeeds(apiURL(this.url));
            },
            getNextFeeds(){
                let url = `${apiURL(this.url)}&page=${(parseInt(this.meta.current_page)+1)}`;
                this.loadFeeds(url)
            },
            generateKey(feed){
                return Math.floor((Math.random() * 1000000));
            },

            loadSingleCommentByData(comment){
                this.mode = 'single';
                this.single_comment = comment;
                this.single_comment_id = null;
            },
            loadSingleCommentById(id){
                this.mode = 'single';
                this.single_comment = null;
                this.single_comment_id = id;
            },
            closeSingleFeed(){
                this.mode = 'feeds';
                this.single_comment = null
            },


        },
        components:{
           CommentFeed, DiscussionFeed, ExperienceFeed, LoadingOne
        },
        mounted() {
            let component = this;
            this.getFeeds();
            let container = component.container == null ? $(window) : $('#feeds-container');
            container.on('scroll',function(e){
            if(onScreen('#more-feeds-loader')) {//if the loader is visible on the screen, It means the bottom has been reached
                if(component.can_load_more && component.links !== null && component.links.next !== null){
                     component.getNextFeeds()
                }
            }
        })

        }
    }
</script>
<style scoped>
    .blur,
    .single-feed-container{
        position: fixed;
        right: 0;
        left: 0;
        bottom: 0;
    }
    .blur{
        top: 0;
        z-index:1100;
        background-color:rgba(255, 255, 255, 0.9);
    }

    .single-feed-container{
        z-index: 1200;
    }
    @media (min-width: 768px){
        .single-feed-container{
            left: 25%;
            right: 25%;
        }
    @media (min-width: 992px){
        .single-feed-container{
            left: 30%;
            right: 30%;
        }

        }
    }
</style>
