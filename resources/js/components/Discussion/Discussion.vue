<template>
    <div>
    <template v-if="is_trashed(discussion)">
        <div class="content-box text-muted" data-toggle="tooltip" title="discussion deleted">
            <!-- <strong class="d-block">{{discussion.title}}</strong>
            <small>{{discussion.snippet}}</small> -->
            <strong>Discussion not available</strong>
        </div>
    </template>
    <template v-else>
        <div class="snippet">
            <div class="float-right bg-info py-1 px-2 small" style="color:#fff">discussion</div>
            <strong><a :href="`/discussion/${discussion.slug}`">{{discussion.title}}</a></strong>
            <div class="pl-2">
                <div>
                    <user :data="discussion.user"></user>
                    <small class="mr-2"> in <a :href="`/forum/${discussion.forum.slug}`">{{discussion.forum.name}}</a></small>
                    <small class="mr-2"><a :href="`/discussion/${discussion.slug}#comments`">{{discussion.comments_count}} comments </a></small>
                    <small class="mr-2">{{time_diff(discussion.createdat_timestamp)}}</small>
                </div> 
            </div>
            <template v-if="discussion.on_training != null">
                <div class="text-muted">
                    On training <strong><a :href="`/training/${discussion.on_training.slug}`">{{discussion.on_training.title}}</a></strong>
                </div>
            </template>
            <div>
                {{discussion.snippet}}
            </div>
            <div>
                <a v-for="tag in discussion.discussion_tags" class="tag" :key="tag" :href="`/tag/${tag}`">{{tag}}</a>
            </div>
            <div class="text-muted">
                Contributors:
                <users :data="discussion.contributors"></users>
            </div>
        </div>
    </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import User from './../User/User';
import Users from './../User/Users';
import Training from './../Training/Training';
export default {
        data(){
            return {
               discussion: this.data
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'time_diff',
                'snippet',
                'is_trashed'
            ]),
            
        },
        props: ['data'],
        methods:{

        },
        components:{
           User,Users,Training
        },
        mounted() {
            console.warn(this.discussion)
            }
    }
</script>

<style scoped>

</style>
