<template>
    <div>
            <div class="comment-scrollable">
                <div style="background-color: #fff; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                    <div class="d-flex shift-left">
                        <img :src="comment.user.image" :alt="comment.user.username" class="avatar avatar-sm">
                        <div class="ml-2 pt-1" >
                            <strong class="d-block">{{comment.user.fullname}}</strong>
                            <a :href="`/@${comment.user.username}`">@{{comment.user.username}}</a> 
                            <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                            <div v-if="comment.reply_to !== null" class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
                        </div> 
                    </div>
                    <!-- If the comment was a reply -->
                    <template v-if="comment.reply_to !== null">
                        <div class="reply_to">
                            <div @click="loadSingleComment(comment.reply_to)" style="">
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
                        <div class="quoted-discussion">
                            <discussion :data="comment.comment_discussion"></discussion>
                        </div>
                    </template>
                    <div @click="loadSingleComment(comment)">
                        {{comment.content}}
                    </div>
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
            </div>
            <div>
                <template v-if="allow_comment">
                    <div class="reply-textarea mb-1">
                        <div class="text-muted">Reply to {{comment.user.fullname}}</div>
                        <comment-textarea :comment="comment.id" @comment-posted="newReplyPosted"></comment-textarea>
                    </div>
                </template>
            </div>

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
                replies_count: this.data.replies_count,
                likes:  this.data.comment_likes,
                allow_comment: this.write_comment
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'is_authenticated',
                'time_diff',
            ]),
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
        props: ['data','quote_discussion','write_comment'],
        methods:{
            ...mapActions([
                'likeComment'
            ]),
             commentLike(){
                this.likeComment(this.comment)
                .then((response) => {
                    if(response.data.action == 'like'){
                        this.likes.push(response.data.like)
                    }else if(response.data.action == 'unlike'){
                        this.likes.splice(getIndex(this.likes, response.data.like), 1);
                    }
                })
                .catch(error => {

                })
               
            },
            loadSingleComment(comment){
                this.$emit('load-single-comment', comment);
            },
            replyComment(){
                    this.allow_comment = this.allow_comment == true ? false : true;
            },
            disallowComment(){
                this.allow_comment = false;
            },
            newReplyPosted(reply){
                this.replies_count++;
                // pass the new reply to the list
                this.$emit('new-reply', reply);
            }
        },
        components:{
            LoadingOne,Discussion,CommentReply, CommentTextarea
        },
        mounted() {
           
        },
        watch: {
             write_comment: function(newValue, oldValue){
                this.write_comment = newValue;
            }
        }
    }
</script>

<style scoped>
    .reply_to{
        border-left:2px solid #eee;
        margin-left: 20px;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 5px
    }
    .quoted-discussion{
        margin-left: 20px
    }

</style>
