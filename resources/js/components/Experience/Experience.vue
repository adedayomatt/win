<template>
    <div>
        <template v-if="is_trashed(experience)">
            <div class="content-box text-muted" data-toggle="tooltip" title="discussion deleted">
                <strong class="d-block">{{experience.title}}</strong>
                <small>{{snippet(experience.content)}}</small>
            </div>
        </template>
        <template v-else>
            <div class="snippet">
                <div class="float-right bg-primary  py-1 px-2 small" style="color:#fff">experience</div>
                <div><a :href="`${root}/experience/${experience.slug}`"><strong>{{experience.title}}</strong></a></div>
                 <div>
                    <div class="ml-2">
                        <user :data="experience.user"></user>
                        <div class="text-muted">
                            <small><a :href="`${root}/experience/${experience.slug}#discussions`">{{experience.discussions_count}} discussions</a></small>
                            <small>{{experience.photos.length}} photos</small>
                            <small>{{experience.videos.length}} videos</small>
                            <small>published {{time_diff(experience.createdat_timestamp)}}</small>
                        </div>
                    </div>
                </div>
                <div>
                    <template v-if="experience.photos.length > 0">
                        <div>
                            <img :src="experience.cover.src" :alt="experience.cover.alt" width="100%">
                        </div>
                    </template>
                    <div>
                        <div>
                            {{experience.snippet}}
                        </div>
                        <div>
                            <a v-for="tag in experience.experience_tags" class="tag" :key="tag" :href="`${root}/tag/${tag}`">{{tag}}</a>
                        </div>

                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import User from './../User/User';

export default {
        data(){
            return {
               experience: this.data
            }
        },
        computed: {
             ...mapGetters([
                'root',
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
           User
        },
        mounted() {
            console.log(this.experience)
            }
    }
</script>

<style scoped>

</style>
