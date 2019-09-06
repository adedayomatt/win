<template>
        <div>
            <div class="d-flex">
                <h6><a :href="`/tag/${tag.name}`" class="tag">#{{tag.name}}</a></h6>
                <div class="ml-auto">
                    <tag-follow-btn  v-bind:prop_tag="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed" ></tag-follow-btn>
                </div>
            </div>
            <div class="text-muted">
                Followed by: <span v-if="is_following_tag(tag)">You, </span>
                <users :prop_users="followers(tag)"></users>
                <div class="d-flex">
                    <small class="m-1">{{tag.discussions_count}} discussions</small>
                    <small class="m-1">{{tag.trainings_count}} trainings</small>
                </div>
            </div>
        </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import Users from './../User/Users';
import TagFollowButton from './TagFollowButton';

    export default {
        name: 'tag-list',
        data(){
            return {
                tag: this.data
            }
        },
        computed: {
            ...mapGetters([
                'auth',
                'app_ready',
                'tags_following',
                'my_tags_loaded',
                'is_following_tag'
            ]),
        },
        props: ['data'],
        methods: {
        tagFollowed(tag){
            tag.followers.push(auth())
        },
        tagUnfollowed(tag){
            removeItem(tag.followers,auth())
        },
        followers(tag){
            return tag.users;
        },
    },
        components: {
            TagFollowButton,Users
        },
        mounted() {
        }
    }
</script>
