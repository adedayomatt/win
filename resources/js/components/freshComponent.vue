<template>
    <div>
        <div v-for="tag in tags" :key="tag.id" class="content-box">
            <div class="d-flex">
                <h6><a href="#" class="tag">#{{tag.name}}</a></h6>
                <div class="ml-auto">
                    <tag-follow-btn :prop_tag="tag" ></tag-follow-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import TagFollowButton from './TagFollowButton.vue';

    export default {
        data(){
            return {
                tags: []
            }
        },
        computed: {

        },
        props: {

        },
        methods:{

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
