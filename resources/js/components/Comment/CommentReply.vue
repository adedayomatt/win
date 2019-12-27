<template>
    <div>
        <div>
            <div class="d-flex shift-left">
                <img :src="comment.user.image.src" :alt="comment.user.username" class="avatar avatar-sm">
                <div class="ml-2 pt-1" >
                    <strong class="d-block">{{comment.user.fullname}}</strong>
                    <a :href="`${root}/@${comment.user.username}`">@{{comment.user.username}}</a>
                    <span class="text-muted ml-2">{{time_diff(comment.created_timestamp)}}</span>
                    <div class="text-muted">Replying to {{comment.reply_to.user.fullname}} <a :href="`/@${comment.reply_to.user.username}`">@{{comment.reply_to.user.username}}</a></div>
                </div> 
            </div>
            <div class="ml-5">
                <div  @click="loadReply" class="single-comment-content break-word">
                    {{comment.content}}
                </div>
                <comment-actions :data="comment" :comment_writable="true" :write_comment="false"></comment-actions>
            </div>
        </div>

                
    </div>
      
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

export default {
        data(){
            return {
                comment: this.reply,
                likes: this.reply.comment_likes,
                replies_count: this.reply.replies_count
            }
        },
        computed: {
             ...mapGetters([
                'root',
                'auth',
                'is_authenticated',
                'time_diff'
            ]),
        },
        props: ['reply'],
        methods:{
            ...mapActions([
                'likeComment'
            ]),
            loadReply(){
                this.$emit('load-reply',this.comment);
            },
        },
        mounted() {

        },
       
    }
</script>

<style scoped>
    .shift-left{
        padding: 10px;
    }
</style>