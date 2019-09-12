<template>
    <div>
        <div>
            <strong class="mr-3">All Contributors</strong>
            <users :data="contributors" @user-clicked="loadUserContributions"></users>
        </div>
        <template v-if="contributor != null">
            <div class="d-flex">
                <div>
                    Comments by:
                    <user :data="contributor"></user>
                </div>
                <div class="ml-auto">
                    <a href="#" @click.prevent="loadAllComments">show all comments</a>
                </div>
            </div>
        </template>
        <comments :url="source" target="discussion" :discussion_id="discussion" @comment-posted="addContributor"></comments>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import Users from './../User/Users';
import Comments from './../Comment/Comments';
import CommentTextarea from './../Comment/CommentTextarea';
export default {
        data(){
            return {
                contributors: [],
                contributor: null,
                source: `/discussion/${this.discussion}/comments`,
            }
        },
        computed: {
            all_comments(){
                return `/discussion/${this.discussion}/comments`;
            }
        },
        props: ['discussion'],
        methods:{
            getContributors(){
                axios.get(apiURL(`/discussion/${this.discussion}/contributors`))
                .then(response => {
                    this.contributors = this.contributors.concat(response.data);
                    console.log(response.data)
                })
                .catch(error => {

                })
            },
            loadUserContributions(user){
                this.contributor = user;
                this.source = `/discussion/${this.discussion}/comments?contributor=${user.username}`
            },
            addContributor(comment){
                this.contributors.push(comment.user);
            },
            loadAllComments(){
                this.source = this.all_comments;
                this.contributor = null;
            }
        },
        components:{
          Users, Comments, CommentTextarea
        },
        mounted() {
            this.getContributors();
        }
    }
</script>
<style scoped>

</style>
