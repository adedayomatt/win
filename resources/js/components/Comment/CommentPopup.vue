<template>
    <div>
        <div class="popup">
            <template v-if="comment !== null">
                <div class="comment-header align-items-center p-1">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex">
                                <img :src="comment.user.image.src" :alt="comment.user.username" class="avatar avatar-sm">
                                <div class="ml-2 pt-1" >
                                    <strong class="d-block">{{`${comment.user.fullname}`}}</strong>
                                    <a :href="`${root}/@${comment.user.username}`">@{{comment.user.username}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <div class="d-flex align-items-center mt-1">
                                <button class="mx-1 btn btn-default no-outline" v-if="prev != null" @click="goBack" title="Go back"><i class="fa fa-arrow-left"></i></button>
                                <button class="mx-1 btn btn-default no-outline" v-if="next != null" @click="goForward" title="Go front"><i class="fa fa-arrow-right"></i></button>
                                <button class="mx-1  btn btn-default no-outline" @click="closePopup" title="close"><i class="fa fa-chevron-down"></i></button>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="comment-body p-2">
                    <div style="background-color: #fff; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                        <div class="quoted-discussion">
                            <discussion :data="comment.comment_discussion"></discussion>
                        </div>
                        <!-- If the comment was a reply -->
                        <template v-if="comment.reply_to !== null">
                            <!-- <div class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div> -->
                            <div class="reply_to">
                                <div  style="">
                                    <div class="d-flex">
                                        <img :src="comment.reply_to.user.image.src" :alt="comment.reply_to.user.username" class="avatar avatar-sm">
                                        <div class="ml-2 pt-1" >
                                            <strong class="d-block">{{comment.reply_to.user.fullname}}</strong>
                                            <a :href="`${root}/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a>
                                            <span class="text-muted ml-2">{{time_diff(comment.reply_to.created_timestamp)}}</span>
                                        </div> 
                                    </div>
                                    <div class="ml-5">
                                        <div class="replied-comment break-word" @click="getComment(comment.reply_to.id)">
                                            {{comment.reply_to.content}}
                                        </div>
                                        <comment-actions :data="comment.reply_to" :write_comment="false" :comment_writable="false"></comment-actions>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                            
                    <div class="d-flex">
                        <img :src="comment.user.image.src" :alt="comment.user.username" class="avatar avatar-sm">
                        <div class="ml-2 pt-1" >
                            <strong class="d-block">{{`${comment.user.fullname}`}}</strong>
                            <a :href="`${root}/@${comment.user.username}`">@{{comment.user.username}}</a>
                            <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                        </div>
                    </div>

                    <div>
                        <div class="main-comment break-word">
                            {{comment.content}}
                        </div>
                        <div class="main-comment-actions">
                            <comment-actions :data="comment" :write_comment="false" :comment_writable="false"></comment-actions>
                        </div>
                    
                    </div>
                        
                    <div>
                        <div class="replies-container">
                            <div v-for="reply in sortedReplies" v-bind:key="reply.id+Math.random()">
                                <comment :data="reply" @load-single-comment="setComment" :quote_comment="false" :write_comment="false"></comment>

                                <!-- <div v-if="reply.thread_id != comment.id">
                                    <comment-reply :reply="reply" @load-reply="getComment(reply.id)"></comment-reply>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div>

                <div class="comment-footer">
                    <div class="px-2">
                        <div class="d-flex">
                            <div class="text-muted">Reply to {{comment.user.fullname}}</div>
                        </div>
                    </div>
                   
                    <div class="reply-textarea">
                        <comment-textarea :comment="comment.id" @comment-posted="newReplyPosted"></comment-textarea>
                    </div>
                </div>

            </template>
            <template v-else>
                <loading-one message="loading comment..."></loading-one>
                <div class="text-center">
                    <button class="btn btn-default btn-sm" @click="closePopup"><i class="fa fa-times"></i> cancel</button>
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
                comment: null,
                replies: [],
                replies_count: 0,
                likes:  [],
                track: [],
                current: null,
            }
        },
        computed: {
             ...mapGetters([
                 'root',
                'auth',
                'is_authenticated',
                'time_diff',
            ]),
            sortedReplies(){
                return this.replies.length > 0 ? this.replies.sort( (a,b) => a.id - b.id ) : null;
            },
            isLiked(){
                if(this.is_authenticated){
                    return this.likes.findIndex(like =>  like.user_id == this.auth.id) < 0 ? false : true;
                }
                return false;
            },
            timeDiff(){
                return this.comment.created_at
            },
            prev(){ //return the previous comment loaded
                let prev_index = this.track.findIndex(item => item.track == this.current.track) - 1;
                return prev_index < 0 ? null : this.track[prev_index].comment;
            },
            next(){
                let next_index = this.track.findIndex(item => item.track == this.current.track) + 1;
                return next_index >= this.track.length ? null : this.track[next_index].comment;
            },
            
            
        },
        props: ['id'],
        methods:{
            ...mapActions([
                'loadComment',
                'likeComment'
            ]),
            setComment(comment){
                this.getComment(comment.id);
            },
            getComment(id){
                this.loadComment(id)
               .then(response => {
                        this.comment =  response.data.comment;
                        this.threads =  response.data.comment.thread;
                        this.likes =  response.data.comment.comment_likes;
                        this.replies = response.data.replies;
                        this.replies_count = response.data.comment.replies_count;
                        let index_in_track = this.track.findIndex(track => track.comment == response.data.comment.id);
                        if(index_in_track < 0){
                            // if the comment is not in the track yet
                            let current = {track: `track_${this.track.length+1}`,comment: response.data.comment.id};
                            this.current = current
                            this.track.push(current)
                        }
                        else{
                            this.current = this.track[index_in_track];
                        }
                    })
            },

            newReplyPosted(reply){
                this.replies_count++;
                this.replies.push(reply)
                this.$emit('new-reply', reply);
            },
            goBack(){
                if(this.prev !==  null){
                    this.getComment(this.prev)
                }
            },
            goForward(){
                if(this.next !==  null){
                    this.getComment(this.next)
                }
            },
            closePopup(){
                this.$emit('close-popup');
            }

        },
        components:{
            LoadingOne,Discussion,CommentReply, CommentTextarea
        },
        mounted() {
                this.getComment(this.id);
        },
        watch: {
            id: function(newId, oldId){
                this.getComment(newId);
            },
        }
    }
</script>

<style scoped>
    .popup{
        background-color: #fff;
    }
    .comment-header{
        background-color: #f7f7f7;
    }
    .navigator{
        cursor: pointer;
    }
    .comment-body{
        max-height: 60vh;
        overflow: auto;
    }
    .comment-footer{

    }
    .replied-comment{
        /* font-size: 12px; */
    }
    .reply_to{
        background-color: #f7f7f7;
        padding: 5px;
        border-radius: 5px;
        border-left: 5px solid #eee;
        margin: 5px 0;
    }
    .main-comment{
        font-size: 18px;
    }
    .main-comment-actions{
        font-size: 22px;
        padding: 5px 0;
        border-top: 1px solid rgba(0,0,0,.125);
        border-bottom: 1px solid rgba(0,0,0,.125)
    }
    .replies-container{
        margin-left: 10px;
    }
    .quoted-discussion{
        margin-left: 20px
    }
</style>
