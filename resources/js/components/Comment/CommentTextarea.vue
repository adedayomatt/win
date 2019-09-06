<template>
    <div>
        <template v-if="is_authenticated">
            <form action="#" method="POST" @submit.prevent="addComment">
                <!-- if it's a comment on a discussion -->
                <input v-if="discussion !== null && discussion !== undefined" type="hidden" name="discussion_id" v-model="discussion_id">
                <!-- if it's reply to a comment -->
                <input v-if="comment !== null && comment !== undefined" type="hidden" name="comment_id" v-model="comment_id">
                <img :src="auth.image" class="commenter-avatar" data-toggle="tooltip" title="Add comment">
                <button type="submit" class="btn btn-theme submit">Post</button>
                <div>
                    <textarea name="content" class="form-control no-outline" placeholder="write here..." v-model="content"></textarea>
                </div>
            </form>
        </template>
        <template v-else>
                <div class="alert alert-warning">sign up to add comment</div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

    export default {
        data(){
            return {
               discussion_id: this.discussion || null,
               comment_id: this.comment || null,
               content: '',
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'is_authenticated'
            ]),
        },
        props: ['discussion','comment'],
        methods:{
            ...mapActions([
                'postComment'
            ]),
            addComment(){
                let comment = {
                    discussion: this.discussion_id,
                    comment: this.comment_id,
                    content: this.content,
                };
               this.postComment(comment)
               .then(response => {
                   this.content = '';
                   this.$emit('comment-posted', response.data.comment)
               })
            }
        },
        mounted() {
           // alert('mounted');
        },
        watch: {
            comment: function(newComment, oldComment){
                this.comment_id = newComment
            },
        }

    }
</script>

<style scoped>
    .commenter-avatar{
        width: 50px; 
        height: 50px;
        border-radius: 50%; 
        border: 2px solid #fff; 
    }
    textarea{
        height: 50px;
        padding: 10px 60px;
        padding-right:70px;
        width: 100%;
        border: none;
        resize:none
    }
    button.submit{
        right: 0;
        height: 50px;
        border-radius: 0
    }
    .commenter-avatar,
    button.submit{
        position:absolute;
        bottom:0;
    }
    @media (min-width:992px) {
    }
</style>
