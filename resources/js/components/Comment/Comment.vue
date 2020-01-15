<template>
    <div>
            <div :class="threads.length > 0 ? `comment-wrapper threaded`: `comment-wrapper`" style="">
                <div :class="threads.length > 0 ? `list-group image-bullet`: ``" style="padding-top: 0;">
                    <div :class="threads.length > 0 ? `list-group-item`: ``" style="background-color: inherit; border-radius: 5px; padding: 5px; ">
                        <div class="d-flex shift-left">
                            <img :src="comment.user.image.src" :alt="comment.user.username" class="avatar avatar-sm">
                            <div class="ml-2 pt-1" >
                                <strong class="d-block">{{comment.user.fullname}}</strong>
                                <a :href="`${root}/@${comment.user.username}`">@{{comment.user.username}}</a> 
                                <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                                <div v-if="comment.reply_to !== null && quote_comment == true" class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
                            </div> 
                        </div>
                        <div class="ml-4">
                        <!-- If the comment was a reply -->
                            <template v-if="comment.reply_to !== null && quote_comment == true">
                                <div class="reply_to">
                                    <div>
                                        <div class="d-flex">
                                            <img :src="comment.reply_to.user.image.src" :alt="comment.reply_to.user.username" class="avatar avatar-sm">
                                            <div class="pt-1" >
                                                <strong class="d-block">{{comment.reply_to.user.fullname}}</strong>
                                                <a :href="`${root}/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a>
                                                <span class="text-muted ml-2">{{time_diff(comment.reply_to.created_timestamp)}}</span>
                                            </div> 
                                        </div>
                                        <div class="single-comment-content break-word" @click="loadSingleCommentById(comment.reply_to.id)">
                                            {{comment.reply_to.content}}
                                        </div>
                                        
                                    </div>
                                </div>
                            </template>
                            <template v-if="quote_discussion">
                                <div class="quoted-discussion">
                                    <discussion :data="comment.comment_discussion"></discussion>
                                </div>
                            </template>

                            <div class="single-comment-content break-word" :id="main_comment_id = makeId('comment')">
                            </div>

                            <comment-actions :data="comment" :expandable="true" @load-single-comment="loadSingleCommentByData" @comment-updated="updateComment"></comment-actions>
                           
                        </div>
                    </div>

                    <template v-if="threads.length > 0">
                        <div class="list-group-item" style="background-color: inherit;">
                            <div v-for="thread in threads" :key="thread.id">
                                <comment-thread :data="thread" @load-thread="loadSingleCommentById" ></comment-thread>
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
                mentions: [],
                threads: this.data.thread,
            }
        },
        computed: {
             ...mapGetters([
                'root',
                'auth',
                'is_authenticated',
                'time_diff',
                'makeId',
                'renderHTML',
                'getMentions',
                'resolveMentions'
            ]),
            
        },
        props: ['data','quote_discussion','quote_comment'],
        methods:{  
            ...mapActions([
            ]),
            loadSingleCommentByData(comment){
                this.$emit('load-single-comment-by-data', comment);
            },
            loadSingleCommentById(id){
                this.$emit('load-single-comment-by-id', id);
            },
            updateComment(comment){
                this.comment = comment;
            },
            // appendContent(){
            //    $('#'+this.identifier).append(this.htmlParsed);
            // }
        },
        components:{
            LoadingOne, Discussion, CommentReply, CommentThread, CommentActions, CommentTextarea
        },
        mounted() {
            this.mentions = this.getMentions(this.comment.content);
            this.renderHTML(this.main_comment_id, this.resolveMentions(this.comment.content, this.mentions));
        },
        watch: {
        }
    }
</script>

<style scoped>

    .reply_to{
        border: 1px solid #eee;
        padding: 5px;
        border-radius: 5px;
    }
    .quoted-discussion{
    }
    .comment-wrapper{
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding:5px 0
    }
    .comment-wrapper.threaded{
        padding-left: 15px
    }

</style>
