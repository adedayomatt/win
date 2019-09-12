<template>
    <div>
        <template v-if="app_ready">
            <template v-if="mode === 'single'">
                <div class="single-comment-container shadow-lg">
                    <div class="float-right"><span class="closer" @click="closeSingleComment">&times;</span></div>
                    <comment :id="single_comment" :write_comment="true" :show_replies="true" @load-single-comment="loadSingleComment" @new-reply="newCommentPosted"></comment>
                </div>
            </template>

            <template v-if="target == `discussion` && meta !== null" >
                Comments: {{total}}
            </template>

            <div id="comments-container" :style="`max-height: ${container}`">
                <div id="comments-wrapper">
                    <template v-if="loaded">
                        <div  class="list-group image-bullet">
                            <div v-for="comment in sortedComments" v-bind:key="comment.id+Math.random()" class="list-group-item comment mb-2" style="background-color: inherit">
                                <comment :data="comment" :show_replies="false" @load-single-comment="loadSingleComment" @new-reply="newCommentPosted"></comment>
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
                single_comment: null,
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
            },
            loadSingleComment(comment){
                this.mode = 'single';
                this.single_comment = comment.id;          
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
        right: 10px;
        left: 10px;
        top: 10%;
        background-color: #fff;
        padding: 5px;
        z-index: 1200;
        border-radius: 7px;
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