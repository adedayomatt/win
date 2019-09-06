<template>
    <div>
        <div @click="loadReply">
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
        <div class="d-flex">
            <span class="mr-2" @click="commentLike">
                <span class="mr-1">{{likes.length}} </span> 
                <span v-if="isLiked"><i class="fas fa-heart text-danger"></i></span>
                <span v-else><i class="far fa-heart"></i></span>
            </span> 
            <span class="ml-2" @click="loadReply">
                 <span class="">{{replies_count}} </span> 
                <span><i class="fa fa-reply text-primary"></i></span>
            </span>
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
                'auth',
                'is_authenticated',
                'time_diff'
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
        props: ['reply'],
        methods:{
            ...mapActions([
                'likeComment'
            ]),
            loadReply(){
                this.$emit('load-reply',this.comment);
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