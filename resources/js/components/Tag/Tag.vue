<template>
        <div>
            <template v-if="tag != null">
                <div class="d-flex">
                    <h6><a :href="`${root}/tag/${tag.name}`" class="tag">#{{tag.name}}</a></h6>
                    <div class="ml-auto">
                        <tag-follow-btn  v-bind:prop_tag="tag" @tag-followed="tagFollowed" @tag-unfollowed="tagUnfollowed" ></tag-follow-btn>
                    </div>
                </div>
                <div class="text-muted">
                    Followed by: 
                    <users :data="followers"></users>
                    <div class="d-flex">
                        <a class="m-1" :href="`${root}/tag/${tag.slug}/discussions`">{{tag.discussions_count}} discussions</a>
                        <a class="m-1"  :href="`${root}/tag/${tag.slug}/experiences`">{{tag.experiences_count}} experiences</a>
                    </div>
                </div>
            </template>
        </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import Users from './../User/Users';
import TagFollowButton from './TagFollowButton';

    export default {
        name: 'tag',
        data(){
            return {
                tag: null,
                followers: [],
            }
        },
        computed: {
            ...mapGetters([
                'root',
                'auth',
                'app_ready',
                'tags_following',
                'my_tags_loaded',
                'is_following_tag'
            ]),
        },
        props: ['data','url'],
        methods: {
        tagFollowed(tag){
            this.followers.push(this.auth);
            this.$emit('tag-followed', tag);
        },
        tagUnfollowed(tag){
            removeItem(this.followers,this.auth);
            this.$emit('tag-unfollowed', tag);
        },
    },
        components: {
            TagFollowButton,Users
        },
        mounted() {
            if(this.data == undefined && this.url != undefined){
                axios.get(apiURL(this.url))
                .then(response => {
                    this.tag = response.data;
                    this.followers = response.data.users
                })
            }else{
                this.tag = this.data;
                this.followers = this.data.users
            }
        }
    }
</script>
