<template>
    <div>
        <div class="d-flex shift-left">
            <img :src="thread.user.image.src" :alt="thread.user.username" class="avatar avatar-sm">
            <div class="ml-2 pt-1" >
                <strong class="d-block">{{thread.user.fullname}}</strong>
                <a :href="`${root}/@${thread.user.username}`">@{{thread.user.username}}</a>
                <span class="text-muted ml-2">{{time_diff(thread.created_timestamp)}}</span>
            </div> 
        </div>
        <div class="ml-4">
            <div class="single-comment-content break-word" :id="thread_body_id = makeId(`thread-${thread.id}-`)">
            </div>
            <comment-actions :data="thread" :expandable="true" @load-single-comment="loadThread"></comment-actions>
        </div>
    </div>
      
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

export default {
        data(){
            return {
                thread: this.data,
                mentions: [],
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
        props: ['data'],
        methods:{
            loadThread(){
                this.$emit('load-thread',this.thread.id);
            },
        },
        mounted() {
            this.mentions = this.getMentions(this.thread.content);
            this.renderHTML(this.thread_body_id, this.resolveMentions(this.thread.content, this.mentions));
        },
       
    }
</script>

<style scoped>

</style>