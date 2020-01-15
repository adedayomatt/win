<template>
    <div>
        <template v-if="mode === 'popup'">
            <div class="blur"></div>
            <div class="single-comment-container shadow-lg">
                <comment-popup :data="single_comment" :id="comment_id"  @new-reply="newCommentPosted" @close-popup="closeSingleComment"></comment-popup>
            </div>
        </template>
        <template v-if="target == `discussion` && meta !== null" >
            Comments: {{total}}
        </template>

        <div id="comments-container" :style="`${container !== null ? 'max-height: '+container+'; overflow-y: auto' : ''}`">
            <template v-if="app_ready">
                    <div id="comments-wrapper">
                        <template v-if="loaded">
                            <div>
                                <div v-for="comment in sortedComments" v-bind:key="comment.id+Math.random()" class="comment" style="background-color: inherit">
                                  <div>
                                        <comment :data="comment" :quote_comment="true" @load-single-comment-by-data="loadSingleCommentByData" @load-single-comment-by-id="loadSingleCommentById"></comment>
                                    </div>
                                </div> 
                            </div>
                            <template v-if="links != null && links.next != null">
                                <div id="more-comments-loader">
                                    <loading-one message="getting more comments..."></loading-one>
                                </div>
                            </template>
                            <template v-else>
                                <div class="text-center">
                                    <h1>.</h1>
                                </div>
                            </template>
                        </template>
                        <template v-else>
                                <loading-one message="getting comments..."></loading-one>
                        </template>
                        
                    </div>
                    <template v-if="target == `discussion`" >
                        <div class="comment-textarea" id="discussion-comment">
                            <comment-textarea :discussion="discussion_id" @comment-posted="newCommentPosted" container="#discussion-comment"></comment-textarea>
                        </div>
                    </template>

            </template>
        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import LoadingOne from './../Assets/LoadingOne';
import Comment from './Comment';
import CommentTextarea from './CommentTextarea';

    export default {
        data(){
            return {
                comments:[],
                links: null,
                meta: null,
                loaded: false,
                can_load_more: true,
                single_comment: null,
                comment_id: null,
                mode: 'list',
                total: 0

            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'app_ready'
            ]),
        sortedComments(){
            return this.comments.sort( (a,b) => b.id - a.id )
        } 
        },
        props: ['container','url', 'target', 'discussion_id'],
        methods:{
            ...mapActions([
                'loadComments'
            ]),
            loadComments(url){
                this.can_load_more = false;
                if(url !== '' && url !== null){
                    axios.get(url)
                    .then(response => {
                        this.comments =  this.comments.concat(response.data.data);
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.loaded = true;
                        this.total = response.data.meta.total;
                        this.can_load_more = true;
                        // console.warn(response.data)
                    })
                    .catch(error => {

                    })
                }
            },
            loadSingleCommentByData(comment){
                this.mode = 'popup';
                this.comment_id = null;
                this.single_comment = comment;  
                // $('*:not(#single-comment-container)').css({'filter':'blur(2px)'})
            },
            loadSingleCommentById(id){
                this.mode = 'popup';
                this.comment_id = id;
                this.single_comment = null;    
                // $('*:not(#single-comment-container)').css({'filter':'blur(2px)'})
            },
            closeSingleComment(){
                this.mode = 'list';
                // $('*:not(#single-comment-container)').css({'filter':'blur(0px)'})
            },
            newCommentPosted(comment){
                this.comments.push(comment);
                this.total++;
                this.$emit('comment-posted', comment);
            }
        },

        components:{
            LoadingOne,Comment,CommentTextarea
        },
        mounted() {
            this.loadComments(apiURL(this.url));
            const component = this;
            let container = component.container == null ? $(window) : $('#comments-container');
            console.log(container);
            container.scroll(function(e){
                let parent = component.container == null ? window : '#comments-container'
                if(onScreen('#more-comments-loader')) { //if the loader is visible on the screen, It means the bottom has been reached
                    if(component.can_load_more && component.links !== null && component.links.next !== null){
                        component.loadComments(component.links.next);
                    }
                }
            })

    
        },
        watch: {
            url: function(newUrl, oldUrl){
                this.comments = [];
                this.loadComments(apiURL(newUrl))
            }
        }
    }
</script>
<style scoped>
    .blur,
    .single-comment-container{
        position: fixed;
        right: 0;
        left: 0;
        bottom: 0;
    }
    .blur{
        top: 0;
        z-index:100;
        background-color:rgba(255, 255, 255, 0.9);
    }

    .single-comment-container{
        z-index: 200;
    }
    
    .list-group-item.comment{
        border: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .comment-textarea{
        position: fixed;
        bottom:0;
        right:0;
        left:0;
    }

    @media (min-width: 768px){
        .single-comment-container{
            left: 50%;
        }
        .comment-textarea{
            left:50%;
        }

    }

    @media (min-width: 992px){
        .single-comment-container{
                left: 70%;
            }

        }
</style>