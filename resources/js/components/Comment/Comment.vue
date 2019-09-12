<template>
    <div>
        <template v-if="comment !== null">
        <div style="background-color: #fff; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                <div @click="loadSingleComment(comment)">
                    <div class="d-flex shift-left">
                        <img :src="comment.user.image" :alt="comment.user.username" class="avatar avatar-sm">
                        <div class="ml-2 pt-1" >
                            <strong class="d-block">{{comment.user.fullname}}</strong>
                            <a :href="`/@${comment.user.username}`">@{{comment.user.username}}</a> 
                            <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                        </div> 
                    </div>
                    {{comment.content}}
                </div>
                <!-- If the comment was a reply -->
                <template v-if="comment.reply_to !== null">
                    <div>
                        <p class="text-muted">Replying to {{comment.reply_to.user.fullname}} @{{comment.reply_to.user.username}}</p>
                        <div @click="loadSingleComment(comment.reply_to)" style="margin-left: 20px; border: 1px solid #eee; border-radius: 5px; padding: 5px">
                            <div class="d-flex">
                                <img :src="comment.reply_to.user.image" :alt="comment.reply_to.user.username" class="avatar avatar-sm">
                                <div class="ml-2 pt-1" >
                                    <strong class="d-block">{{comment.reply_to.user.fullname}}</strong>
                                    <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a>
                                    <span class="text-muted ml-2">{{time_diff(comment.reply_to.created_timestamp)}}</span>
                                </div> 
                            </div>
                            {{comment.reply_to.content}}
                        </div>
                    </div>
                </template>
                <template v-if="quote_discussion">
                    <div style="margin-left: 20px">
                        <discussion :data="comment.comment_discussion"></discussion>
                    </div>
                </template>
                
                <div class="d-flex">
                    <span class="mr-2" @click="commentLike">
                        <span class="mr-1">{{likes.length}} </span> 
                        <span v-if="isLiked"><i class="fas fa-heart text-danger"></i></span>
                        <span v-else><i class="far fa-heart"></i></span>
                    </span> 
                    <span class="ml-2" @click="replyComment">
                        <span class="">{{replies_count}}</span> 
                        <span v-if="allow_comment"><i class="fa fa-reply text-primary"></i></span>
                        <span v-else><i class="fa fa-reply"></i></span>
                    </span>
                     
                </div>
            </div>
            <div>
                <template v-if="show_replies && sortedReplies != null">
                    <div class="replies-container">
                        <div  class="list-group image-bullet">
                            <div v-for="reply in sortedReplies" v-bind:key="reply.id+Math.random()" class="list-group-item">
                                <comment-reply :reply="reply" @load-reply="loadReply"></comment-reply>
                        </div>
                        </div>
                    </div>
                </template>
                <template v-if="allow_comment">
                    <div class="reply-textarea">
                        <div class="text-muted">Replying to {{comment.user.fullname}}</div>
                        <comment-textarea :comment="comment.id" @comment-posted="newReplyPosted"></comment-textarea>
                    </div>
                </template>
            </div>
        </template>
        <template v-else>
            <loading-one message="just a bit..."></loading-one>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import LoadingOne from './../Assets/LoadingOne'
import Discussion from './../Discussion/Discussion'
import CommentReply from './CommentReply'
import CommentTextarea from './CommentTextarea.vue'

export default {
        data(){
            return {
                comment: this.data || null,
                replies: [],
                replies_count: 0,
                likes:  [],
                allow_comment: this.write_comment
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'is_authenticated',
                'time_diff',
            ]),
            sortedReplies(){
                return this.replies.length > 0 ? this.replies.sort( (a,b) => b.id - a.id ) : null;
            },
            isLiked(){
                if(this.is_authenticated){
                    return this.likes.findIndex(like =>  like.user_id == this.auth.id) < 0 ? false : true;
                }
                return false;
            },
            timeDiff(){
                return this.comment.created_at
            }
            
        },
        props: ['id','data','quote_discussion','show_replies','write_comment'],
        methods:{
            ...mapActions([
                'loadComment',
                'likeComment'
            ]),
            getComment(id){
                this.loadComment(id)
               .then(response => {
                        this.comment =  response.data.comment;
                        this.likes =  response.data.comment.comment_likes;
                        this.replies = response.data.replies;
                        this.replies_count = response.data.comment.replies_count;
                    })
                    
            },
            setComment(data){
                this.comment = data;
                this.likes = data.comment_likes;
                this.replies_count = data.replies_count;
            },
            loadReply(reply){
                this.$emit('load-single-comment', reply);
            },
            loadSingleComment(comment){
                this.$emit('load-single-comment', comment);
            },
             commentLike(){
                this.likeComment(this.comment)
                .then((response) => {
                    if(response.data.action == 'like'){
                        this.likes.push(response.data.like)
                    }else if(response.data.action == 'unlike'){
                        this.likes.splice(getIndex(this.likes, response.data.like), 1);
                    }
                })
               
            },
            replyComment(){
                    this.allow_comment = true
            },
            disallowComment(){
                this.allow_comment = false;
            },
            newReplyPosted(reply){
                if(this.replies == null){
                    this.replies = [];
                    this.replies[0] = reply;
                }else{
                    this.replies.push(reply)
                }
                this.replies_count++;
                // pass the new reply to the list
                this.$emit('new-reply', reply);
            }
        },
        components:{
            LoadingOne,Discussion,CommentReply, CommentTextarea
        },
        mounted() {
            //if it was url that was passed
            if(this.comment == null && this.url !== null){
                this.getComment(this.id);
            }else{
                this.setComment(this.data);
            }
        },
        watch: {
            id: function(newId, oldId){
                this.getComment(newId);
            },
             write_comment: function(newValue, oldValue){
                this.write_comment = newValue;
            }
        }
    }
</script>

<style scoped>

    .replies-container{
        max-height: 50vh;
        margin-left: 10px;
        overflow: auto;
    }
</style>
