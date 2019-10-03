<template>
    <div>
                <div class="d-flex shift-left">
                    <img :src="thread.user.image" :alt="thread.user.username" class="avatar avatar-sm">
                    <div class="ml-2 pt-1" >
                        <strong class="d-block">{{thread.user.fullname}}</strong>
                        <a :href="`/@${thread.user.username}`">@{{thread.user.username}}</a>
                        <span class="text-muted ml-2">{{time_diff(thread.created_timestamp)}}</span>
                    </div> 
                </div>
                <div class="ml-5">
                    <div @click="loadThread(thread)">
                        {{thread.content}}
                    </div>
                    <comment-actions :data="thread" :write_comment="false" :comment_writable="true" @new-reply="newReply"></comment-actions>
                    
                    <!-- Replies add now -->
                    <div v-for="reply in replies" :key="reply.id" style="padding: 5px; border:1px solid #f7f7f7; border-radius: 5px">
                        <div class="d-flex">
                            <img :src="reply.user.image" :alt="reply.user.username" class="avatar avatar-xs">
                            <div class="ml-2 pt-1" >
                                <strong class="d-block">{{reply.user.fullname}}</strong>
                                <a :href="`/@${reply.user.username}`">@{{reply.user.username}}</a>
                                <span class="text-muted ml-2">{{time_diff(reply.created_timestamp)}}</span>
                            </div> 
                        </div>
                        <div @click="loadReply(reply)" style="font-style: italic">
                            {{reply.content}}
                        </div>
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
                thread: this.comment,
                replies: []
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'is_authenticated',
                'time_diff'
            ]),

        },
        props: ['comment'],
        methods:{
            ...mapActions([
                'likeComment'
            ]),
            loadThread(thread){
                this.$emit('load-thread',thread);
            },
            newReply(reply){
                this.replies.push(reply)
            }
        },
        mounted() {

        },
       
    }
</script>

<style scoped>

</style>