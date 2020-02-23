<template>
    <div>
        <div class="d-flex">
            <span class="mx-2 action" @click="commentLike">
                <span class="mr-1">{{comment.likes_count}} </span> 
                <span v-if="comment.liked"><i class="fas fa-heart text-danger"></i></span>
                <span v-else><i class="far fa-heart"></i></span>
            </span> 
            <span class="mx-2 action" @click="loadSingleComment">
                <span class="">{{comment.replies_count}}</span> 
                <span><i class="fa fa-reply"></i></span>
            </span>

            <template v-if="expandable">
                <span class="mx-2 ml-auto action" @click="loadSingleComment">
                    <span><i class="fa fa-external-link-alt" title="open comment"></i></span>
                </span>
            </template>

            <!-- <span class="ml-auto action mentions" >
                <button type="button" class="btn btn-default border-1 no-outline" style="border: 1px solid #f7f7f7;" @click="showMentions"><i class="fa fa-users"></i></button>
            </span> -->

        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

export default {
        data(){
            return {
                comment: this.data,
            }
        },
        computed: {
             ...mapGetters([
                'root',
                'auth',
                'is_authenticated',
                'time_diff',
                'getMentions',
            ]),
            timeDiff(){
                return this.comment.created_at
            }
            
        },
        props: ['data', 'expandable'],
        methods:{
            ...mapActions([
                'apiCall'
            ]),
             commentLike(){
                this.apiCall({
                    endpoint: `/comment/${this.comment.id}/like`,
                    method: 'POST'
                    })
                .then((response) => {
                    if(response.data.action == 'like'){
                        this.comment.likes_count++;
                        this.comment.liked = true;
                    }else if(response.data.action == 'unlike'){
                        this.comment.likes_count--;
                        this.comment.liked = false;
                    }
                    this.$emit('comment-updated', this.comment);
                })
                .catch(error => {

                })
               
            },
            loadSingleComment(){
                this.$emit('load-single-comment', this.comment);
            },
            showMentions(){
                let container = this.container;
                let mentions_list = '';
                if(this.mentions !== undefined && this.mentions.length > 0){
                    mentions_list = `<div class="list-group">`;
                    this.mentions.forEach(mention => {
                      mentions_list += `<div class="list-group-item"><a href="${this.root}/${mention}">${mention}</a></div>`;  
                    });
                    mentions_list += `</div>`;
                }else{
                    mentions_list = 'No mention in the comment'
                }
                $(`.mentions-popover`).popover({
                    html: true,
                    title: 'Mentions',
                    placement: 'auto',
                    container: document.querySelector(container),
                    content: mentions_list
                })
            }
        },
        components:{

        },
        mounted() {
            this.mentions = this.getMentions(this.comment.content);
        },
        watch: {
            data: function(newData, oldData){
                this.comment = newData;
            },
        }
    }
</script>

<style scoped>
    .action{
        cursor: pointer;
    }
</style>
