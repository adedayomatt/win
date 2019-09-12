<template>
    <div>
         <template v-if="mode === 'single'">
            <div class="single-feed-container shadow-lg">
                <div class="float-right"><span class="closer" @click="closeSingleFeed">&times;</span></div>
                <comment :id="single_comment" :quote_discussion="true" :write_comment="true" :show_replies="true" @load-single-comment="getComment"></comment>
            </div>
        </template>
        <div id="feeds-container" :style="`max-height: ${container}`">
            <div id="feeds-wrapper">
                <template v-if="loaded">
                    <div v-for="feed in computedFeeds" :key="generateKey(feed)">
                        <template  v-if="feed.type == 'comment'">
                            <comment :data="feed" @load-single-comment="getComment" :quote_discussion="true"></comment>
                        </template>
                        <template v-else-if="feed.type == 'discussion'">
                            <discussion  :data="feed"></discussion>
                        </template>
                        <template v-else-if="feed.type == 'training'" >
                            <training :data="feed"></training>
                        </template>
                    </div>
                    <template v-if="links !== null && links.next !== null">
                        <loading-one message="loading more feeds..."></loading-one>
                    </template>
                    <template v-else>
                        <div class="text-center">
                            <h1>.</h1>
                        </div>
                    </template>

                </template>
                <template v-else>
                    <loading-one message="loading feeds..."></loading-one>
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
import TrainingFeed from './TrainingFeed'
import LoadingOne from './../Assets/LoadingOne'

export default {
        data(){
            return {
               key: 1,
               feeds: [],
               links: null,
               mode: 'feeds',
               loaded: false,
               single_comment: null,
               single_discussion: null,
               single_training: null,
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
                'loadComment'
            ]),

            getFeeds(url){
                axios.get(url)
                .then(response => { 
                    this.feeds = this.feeds.concat(response.data.data);
                    this.links = response.data.links;
                    this.loaded = true;
                })
                .catch(error => {

                })
            },
            generateKey(feed){
                return Math.floor((Math.random() * 1000000));
            },
            getComment(comment){
                this.mode = 'single';
                this.single_comment = comment.id;
            },
            closeSingleFeed(){
                this.mode = 'feeds';
                this.single_comment = null
            }

        },
        components:{
           CommentFeed, DiscussionFeed, TrainingFeed, LoadingOne
        },
        mounted() {
            let component = this;
            this.getFeeds(apiURL(component.url));
            
            let container = component.container == null ? $(window) : $('#feeds-container');
            container.on('scroll',function(e){
            let content = $('#feeds-wrapper');
            console.log('content:'+content.height()+' scrolled:'+container.scrollTop());
            if(container.scrollTop() + container.height() >= content.height()){
                if(component.links !== null && component.links.next !== null){
                    component.getFeeds(component.links.next)
                }
            }
            })
        }
    }
</script>
<style scoped>
    .single-feed-container{
        position: fixed;
        right: 10px;
        left: 10px;
        top: 10%;
        background-color: #fff;
        padding: 5px;
        z-index: 1200000;
        border-radius: 7px;
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
