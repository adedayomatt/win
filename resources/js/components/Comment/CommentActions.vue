<template>
    <div>
        <div class="d-flex">
            <span class="mr-2 comment-like-btn" @click="commentLike">
                <span class="mr-1">{{likes_count}} </span> 
                <span v-if="isLiked"><i class="fas fa-heart text-danger"></i></span>
                <span v-else><i class="far fa-heart"></i></span>
            </span> 
            <span class="ml-2 comment-reply-btn" @click="replyComment">
                <span class="">{{replies_count}}</span> 
                <span v-if="allow_comment"><i class="fa fa-reply text-primary"></i></span>
                <span v-else><i class="fa fa-reply"></i></span>
            </span>
        </div>
        <div>
            <template v-if="allow_comment && comment_writable">
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
import CommentReply from './CommentReply.vue'
import CommentTextarea from './CommentTextarea.vue'

export default {
        data(){
            return {
                comment: this.data,
                recent_replies: [],
                replies_count: this.data.replies_count,
                likes_count: this.data.likes_count,
                likes:  this.data.likes,
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
        props: ['data','comment_writable','write_comment'],
        methods:{
            ...mapActions([
                'likeComment'
            ]),
             commentLike(){
                this.likeComment(this.comment)
                .then((response) => {
                    if(response.data.action == 'like'){
                        this.likes.push(response.data.like);
                        this.likes_count++;
                    }else if(response.data.action == 'unlike'){
                        this.likes.splice(getIndex(this.likes, response.data.like), 1);
                        this.likes_count--;
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
                this.allow_comment = false;
                this.$emit('new-reply', reply);
            }
        },
        components:{
            CommentReply, CommentTextarea
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
    .comment-like-btn,
    .comment-reply-btn{
        cursor: pointer;
    }
</style>
