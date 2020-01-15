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
                            <div class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`${root}/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
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
                                        <!-- <comment-actions :data="comment.reply_to"></comment-actions> -->
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

                        <div class="main-comment break-word" :id="comment_body_id"></div>

                        <div class="main-comment-actions">
                            <comment-actions :data="comment" :expandable="false" @comment-updated="updateComment"></comment-actions>
                        </div>
                    
                    </div>
                        
                    <div>
                        <template v-if="engagements_loaded">
                            <div class="replies-container">
                                <div v-for="reply in replies" v-bind:key="reply.id+Math.random()">
                                    <comment :data="reply" @load-single-comment-by-data="setComment" @load-single-comment-by-id="getComment" :quote_comment="false" :quote_discussion="false"></comment>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <loading-one message="loading engagement..."></loading-one>
                        </template>
                    </div>

                </div>

                <div class="comment-footer">
                    <div class="px-2">
                        <div class="d-flex">
                            <div class="text-muted">Reply to {{comment.user.fullname}}</div>
                        </div>
                    </div>
                   
                    <div class="reply-textarea" id="pop-up-textarea">
                        <comment-textarea :comment="comment.id" container="#pop-up-textarea" @comment-posted="newReplyPosted"></comment-textarea>
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
                mentions: [],
                replies: [],
                track: [],
                current: null,
                engagements_loaded: false,
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
            comment_body_id(){
                return  this.makeId(`pop-c-${this.comment.id}`);
            },
            timeDiff(){
                return this.comment.created_at
            },
            prev(){ //return the previous comment loaded
                let prev_index = this.track.findIndex(c => c.id == this.current.id) - 1;
                return prev_index < 0 ? null : this.track[prev_index];
            },
            next(){
                let next_index = this.track.findIndex(c => c.id == this.current.id) + 1;
                return next_index >= this.track.length ? null : this.track[next_index];
            },
        },
        props: ['data', 'id'],
        methods:{
            ...mapActions([
                'loadComment',
                'loadCommentEngagements',
            ]),
            setData(data){
                return new Promise((resolve, reject) => {
                    this.comment = data;
                    resolve(data);
                })
            },
            setTrack(comment){
                let index_in_track = this.track.findIndex(c => c.id == comment.id);
                if(index_in_track < 0){
                    // if the comment is not in the track yet
                    let current = comment;
                    this.current = current
                    this.track.push(current)
                }
                else{
                    this.current = this.track[index_in_track];
                }
            },
            setComment(comment){
                this.setData(comment)
                .then((data) => {
                    this.mentions = this.getMentions(comment.content);
                    this.renderHTML(this.comment_body_id, this.resolveMentions(comment.content, this.mentions));
                    
                    this.getEngagements();
                    //set in the track
                    this.setTrack(comment);
                })
            },
            //load comment by id
            getComment(id){
                this.loadComment(id)
               .then(response => {
                       this.setComment(response.data.comment);
               });
            },

            getEngagements(){
                this.engagements_loaded = false;
                this.loadCommentEngagements(this.comment.id)
                .then(response => {
                        this.comment.likes =  response.data.likes;
                        this.comment.likes_count = response.data.likes.length;
                        this.replies = response.data.replies.sort( (a,b) => a.id - b.id ); response.data.replies;
                        this.comment.replies_count = response.data.replies.length;
                        this.engagements_loaded = true;
                })
            },

            newReplyPosted(reply){
                this.replies.push(reply);
                this.comment.replies_count++;
                this.$emit('new-reply', reply);
            },
            goBack(){
                if(this.prev !==  null){
                    this.setComment(this.prev)
                }
            },
            goForward(){
                if(this.next !==  null){
                    this.setComment(this.next)
                }
            },
            closePopup(){
                this.$emit('close-popup');
            },
            updateComment(comment){
                this.comment = comment;
            },
        },
        components:{
            LoadingOne,Discussion,CommentReply, CommentTextarea
        },
        mounted() {
            //if the data was passed
            if(this.data != null && this.data != undefined){
              this.setComment(this.data);
            }
            //if it was an id
            else if(this.id != null && this.id != undefined){
                this.getComment(this.id);
            }
        },
        watch: {
            data: function(newData, oldData){
                if(newData != null){
                    this.setComment(newData);
                }
            },
            id: function(newId, oldId){
                if(newId != null){
                    this.getComment(newId);
                }
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
