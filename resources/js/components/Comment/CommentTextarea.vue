<template>

    <div>
        <template v-if="is_authenticated">
            <form action="#" method="POST" @submit.prevent="addComment">
                <!-- if it's a comment on a discussion -->
                <input v-if="discussion !== null && discussion !== undefined" type="hidden" name="discussion_id" v-model="discussion_id">
                <!-- if it's reply to a comment -->
                <input v-if="comment !== null && comment !== undefined" type="hidden" name="comment_id" v-model="comment_id">
                <img :src="auth.image.src" :alt="auth.username" class="commenter-avatar" data-toggle="tooltip" title="Add comment">
                <button v-if="contentFilled" type="submit" class="no-outline btn primary-color submit">Post</button>
                <button v-else type="button" class="no-outline btn primary-color submit" disabled>Post</button>
                <template>
                    <!-- <at :members="members">
                        <div class="form-control no-outline" role="editor" contenteditable="true"  @keyup="setContent" v-html="content"></div>
                    </at> -->
                    <textarea name="content" class="form-control no-outline mention-user comment" role="editor"  placeholder="write here..." @keyup="setContent" v-model="content"></textarea>
                </template>
            </form>
            <template v-if="mentions.length > 0">
                <div class="mentions-container">
                    mentions: <a v-for="mention in mentions" :href="`${root}/${mention}`" v-bind:key="mention" class="mention">{{mention}}</a>
                </div>
            </template>
        </template>
        <template v-else>
                <div class="alert alert-info mb-0">
                    <a :href="`${root}/login`">sign in</a>  to add comment or <a :href="`${root}/register`">Sign up</a>
                </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
// import At from 'vue-at';

    export default {
        data(){
            return {
               discussion_id: this.discussion || null,
               comment_id: this.comment || null,
               mentions: [],
               content: '',
               members: ['Kayode', 'Ifeoluwa', 'Olivia']
            }
        },
        computed: {
             ...mapGetters([
                'root',
                'auth',
                'is_authenticated'
            ]),
            editor(){
                return `${this.container} [role = 'editor']`
            },
            contentFilled(){
                return this.content == '' ? false : true;
            },
        },
        props: ['discussion','comment', 'container'],
        methods:{
            ...mapActions([
                'postComment'
            ]),
            setContent(){
                $(this.editor).focus();
                // this.content = $(this.editor).html();
                this.content = $(this.editor).val();
            },
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
            },
        },
        mounted() {
            if(this.is_authenticated){
                enableMentions(".mention-user", "users", "username");
            }

        },
        components:{
            //  At 
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
    [role='editor']{
        height: 50px;
        overflow-y: auto;
        padding: 10px 60px;
        padding-right:70px;
        width: 100%;
        border: none;
        resize:none
    }
    button.submit{
        right: 10px;
        height: 50px;
        border-radius: 0
    }
    .commenter-avatar,
    button.submit{
        position:absolute;
        z-index:100;
    }
    .mentions-container{
        background-color: #f7f7f7;
        padding: 10px;
        overflow-x:auto;
    }
    a.mention{
        background-color: #fff;
        padding: 5px;
        margin:3px;
        border-radius: 3px;
        text-decoration: none;
    }
    @media (min-width:992px) {
    }
</style>
