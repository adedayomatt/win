<template>
    <div>
            <div>
                <div :class="threads.length > 0 ? `list-group image-bullet`: ``" style="padding-top: 0">
                    <div :class="threads.length > 0 ? `list-group-item`: ``" style="background-color: inherit; border-radius: 5px; padding: 5px;">
                        <div class="d-flex shift-left">
                            <img :src="comment.user.image" :alt="comment.user.username" class="avatar avatar-sm">
                            <div class="ml-2 pt-1" >
                                <strong class="d-block">{{comment.user.fullname}}</strong>
                                <a :href="`/@${comment.user.username}`">@{{comment.user.username}}</a> 
                                <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                                <div v-if="comment.reply_to !== null && quote_comment == true" class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
                            </div> 
                        </div>
                        <div class="ml-4">
                        <!-- If the comment was a reply -->
                            <template v-if="comment.reply_to !== null && quote_comment == true">
                                <div class="reply_to single-comment">
                                    <div @click="loadSingleComment(comment.reply_to)" class="">
                                        <div class="d-flex">
                                            <img :src="comment.reply_to.user.image" :alt="comment.reply_to.user.username" class="avatar avatar-sm">
                                            <div class="pt-1" >
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
                            <div @click="loadComment" class="single-comment">
                                {{comment.content}}
                            </div>
                            <comment-actions :data="comment" :write_comment="write_comment" :comment_writable="true" @new-reply="newReply"></comment-actions>
                           
                            <!-- Replies add now -->
                            <div v-for="reply in replies" :key="reply.id" class="my-1" style="padding: 5px; border:1px solid #f7f7f7; border-radius: 5px">
                                <div class="d-flex">
                                    <img :src="reply.user.image" :alt="reply.user.username" class="avatar avatar-xs">
                                    <div class="ml-2 pt-1" >
                                        <strong class="d-block">{{reply.user.fullname}}</strong>
                                        <a :href="`/@${reply.user.username}`">@{{reply.user.username}}</a>
                                        <span class="text-muted ml-2">{{time_diff(reply.created_timestamp)}}</span>
                                    </div> 
                                </div>
                                <div @click="loadSingleComment(reply)">
                                    {{reply.content}}
                                </div>
                            </div>

                        </div>
                    </div>

                    <template v-if="threads.length > 0">
                        <div class="list-group-item" style="background-color: inherit;">
                            <div v-for="thread in threads" :key="thread.id">
                                <comment-thread :comment="thread" @load-thread="loadThread"></comment-thread>
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
import LoadingOne from './../Assets/LoadingOne'
import Discussion from './../Discussion/Discussion'
import CommentReply from './CommentReply'
import CommentThread from './CommentThread'
import CommentActions from './CommentActions'
import CommentTextarea from './CommentTextarea.vue'

export default {
        data(){
            return {
                comment: this.data,
                threads: this.data.thread,
                replies: [],
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'is_authenticated',
                'time_diff',
            ]),
            
        },
        props: ['data','quote_discussion','quote_comment','write_comment'],
        methods:{               
            loadSingleComment(comment){
                this.$emit('load-single-comment', comment);
            },
            loadComment(){
                this.loadSingleComment(this.comment)
            },
            loadThread(thread){
                this.loadSingleComment(thread)
            },
            loadReply(reply){
                this.loadSingleComment(reply)
            },
            newReply(reply){
                this.replies.push(reply);
            }
        },
        components:{
            LoadingOne, Discussion, CommentReply, CommentThread, CommentActions, CommentTextarea
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
        border: 1px solid #eee;
    }
    .quoted-discussion{
    }

</style>
