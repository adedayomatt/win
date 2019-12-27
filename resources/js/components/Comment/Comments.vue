<template>
    <div>
        <template v-if="app_ready">
            <template v-if="mode === 'popup'">
                <div class="single-comment-container shadow-lg">
                    <comment-popup :id="popup_comment"  @new-reply="newCommentPosted" @close-popup="closeSingleComment"></comment-popup>
                </div>
            </template>

            <template v-if="target == `discussion` && meta !== null" >
                Comments: {{total}}
            </template>

            <div id="comments-container" :style="`max-height: ${container}`">
                <div id="comments-wrapper">
                    <template v-if="loaded">
                        <div>
                            <div v-for="comment in sortedComments" v-bind:key="comment.id+Math.random()" class="comment" style="background-color: inherit">
                                <div>
                                    <comment :data="comment" :quote_comment="true" @load-single-comment="loadSingleComment"></comment>
                                </div>
                               
                            </div> 
                        </div>
                    </template>
                    <template v-else>
                            <loading-one message="Fetching comments..."></loading-one>
                    </template>
                    <template v-if="links != null && links.next != null">
                        <loading-one message="Fetching more comments..."></loading-one>
                    </template>
                    <template v-else>
                        <div class="text-center">
                            <h1>.</h1>
                        </div>
                    </template>

                </div>
            </div>
            <template v-if="target == `discussion`" >
                <div class="comment-textarea">
                    <comment-textarea :discussion="discussion_id" @comment-posted="newCommentPosted"></comment-textarea>
                </div>
            </template>
           
        </template>
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
                popup_comment: null,
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
                if(url !== '' && url !== null){
                    axios.get(url)
                    .then(response => {
                        this.comments =  this.comments.concat(response.data.data);
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.loaded = true;
                        this.total = response.data.meta.total;
                        console.warn(response.data)
                    })
                    .catch(error => {

                    })
                }
            },
            loadSingleComment(comment){
                this.mode = 'popup';
                this.popup_comment = comment.id;          
                },
            closeSingleComment(){
                this.mode = 'list';
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
            const component = this;

            this.loadComments(apiURL(this.url));
            let container = component.container == null ? $(window) : $('#comments-container');
            container.on('scroll',function(e){
            let content = $('#comments-wrapper');
            console.log('content:'+content.height()+' scrolled:'+container.scrollTop());
            if(container.scrollTop() + container.height() >= content.height()){
                if(component.links !== null && component.links.next !== null){
                    setTimeout(() => { 
                        component.loadComments(component.links.next)
                        },3000)
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
    .single-comment-container{
        position: fixed;
        right: 0;
        left: 0;
        bottom: 0;
        z-index: 1200;
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