<template>
    <div>
        <div class="popup">
            <template v-if="comment !== null">
                <div class="comment-header align-items-center p-1">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex">
                                <img :src="comment.user.image" class="avatar avatar-sm">
                                <div class="ml-2 pt-1" >
                                    <strong class="d-block">{{`${comment.user.fullname}`}}</strong>
                                    <a :href="`/@${comment.user.username}`">@{{comment.user.username}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <div class="d-flex align-items-center">
                                <button class="mx-1 btn btn-default no-outline" v-if="prev != null" @click="goBack">BACK</button>
                                <button class="mx-1 btn btn-default no-outline" v-if="next != null" @click="goForward">FRONT</button>
                                <span class="mx-1 closer" @click="closePopup">&times;</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="comment-body p-2">
                    <div style="background-color: #fff; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                        <!-- If the comment was a reply -->
                        <template v-if="comment.reply_to !== null">
                            <div class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
                            <div class="reply_to">
                                <div @click="getComment(comment.reply_to.id)" style="">
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
                        <div class="quoted-discussion">
                            <discussion :data="comment.comment_discussion"></discussion>
                        </div>
                        <div>
                            {{comment.content}}
                        </div>

                    </div>

                    <div>
                        <div class="replies-container">
                            <div  class="list-group image-bullet">
                                <div v-for="reply in sortedReplies" v-bind:key="reply.id+Math.random()" class="list-group-item">
                                    <comment-reply :reply="reply" @load-reply="getComment(reply.id)"></comment-reply>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comment-footer">
                    <div class="px-2">
                        <div class="d-flex">
                            <div class="text-muted">Reply to {{comment.user.fullname}}</div>
                            <div class="ml-auto">
                                <div class="d-flex">
                                    <span class="mr-2" @click="commentLike">
                                        <span class="mr-1">{{likes.length}} </span> 
                                        <span v-if="isLiked"><i class="fas fa-heart text-danger"></i></span>
                                        <span v-else><i class="far fa-heart"></i></span>
                                    </span> 
                                    <span class="ml-2">
                                        <span class="">{{replies_count}}</span> 
                                        <span><i class="fa fa-reply text-primary"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="reply-textarea">
                        <comment-textarea :comment="comment.id" @comment-posted="newReplyPosted"></comment-textarea>
                    </div>
                </div>

            </template>
            <template v-else>
                <loading-one message="just a bit..."></loading-one>
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
            getComment(id){
                this.loadComment(id)
               .then(response => {
                        this.comment =  response.data.comment;
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

            newReplyPosted(reply){
                this.replies.push(reply)
                this.replies_count++;
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
        max-height: 70vh;
        overflow: auto;
    }
    .comment-footer{
        
    }
    .reply_to{
        border-left:2px solid #eee;
        margin-left: 20px;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 5px
    }
    .replies-container{
        margin-left: 10px;
    }
    .quoted-discussion{
        margin-left: 20px
    }
</style>
