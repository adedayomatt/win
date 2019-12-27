<template>
    <div>
        <template v-if="is_trashed(training)">
            <div class="content-box text-muted" data-toggle="tooltip" title="discussion deleted">
                <strong class="d-block">{{training.title}}</strong>
                <small>{{snippet(training.content)}}</small>
            </div>
        </template>
        <template v-else>
            <div class="snippet row row-eq-height">
                <div class="col-4" :style="`background-image: url('${training.cover.src}'); background-size: cover; background-repeat: no-repeat; background-position: center`">
                    <img class="d-none" :src="training.cover.src" width="100%">
                </div>
                <div class="col-8">
                    <div class="float-right bg-primary  py-1 px-2 small" style="color:#fff">training</div>
                    <div class="card-title">
                        <div>
                            <a :href="`/training/${training.slug}`"><strong>{{training.title}}</strong></a>
                            <div class="ml-2">
                                <user :data="training.user"></user>
                                <div class="text-muted">
                                    <small><a :href="`training/${training.slug}#discussions`">{{training.discussions_count}} discussions</a></small>
                                    <small>{{training.photos.length}} photos</small>
                                    <small>{{training.videos.length}} videos</small>
                                    <small>published {{time_diff(training.createdat_timestamp)}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        {{training.snippet}}
                    </div>
                    <div>
                        <a v-for="tag in training.training_tags" class="tag" :key="tag" :href="`${root}/tag/${tag}`">{{tag}}</a>
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
               training: this.data
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
            console.log(this.training)
            }
    }
</script>

<style scoped>

</style>
