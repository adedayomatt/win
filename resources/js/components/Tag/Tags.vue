<template>
    <div id="tag-list-container" :style="container != null ? `max-height:${container}; overflow:auto` : ''">
        <div :id="id" >
            <template v-if="app_ready">
                <div v-for="tag in tags" v-bind:key="tag.id+Math.random()" class="content-box">
                    <tag :data="tag"></tag>
                </div>
            <template v-if="links != null && links.next != null">
                <div class="text-center">
                     <loading-one message="loading more..."></loading-one>
                </div>
            </template>
            <template v-else>
                <div class="text-center">
                    <h1>.</h1>
                </div>
            </template>

            </template>
            <template v-else>
                <loading-one message="loading tags"></loading-one>
            </template>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import Tag from './Tag';
import TagFollowButton from './TagFollowButton';
import LoadingOne from './../Assets/LoadingOne';
    export default {
        name: 'tags',
        data(){
            return {
                tags: [],
                links: null,
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
        props: [ 'id', 'container','url', 'collection'],
        methods: {
        loadTags(url){
                    axios.get(url)
                    .then(response => {
                      this.tags =  this.tags.concat(response.data.data);
                        this.links = response.data.links
                        this.loaded = true;
                        console.warn(response.data)
                    })
                    .catch(error => {

            })
        },
    },
        components: {
            Tag,TagFollowButton,LoadingOne
        },
        mounted() {
            const component = this;
            if(this.collection == null && this.url !== null){
                this.loadTags(this.url);
                let container = this.container == null ? $(window) : $('#tag-list-container');
                container.on('scroll',function(e){
                let content = $(`#tag-list-container #${component.id}`);
                console.log('content:'+content.height()+'scrolled:'+container.scrollTop());
                if(container.scrollTop() + container.height() >= content.height()){
                    if(component.links !== null && component.links.next !== null){
                        setTimeout(() => { 
                            component.loadTags(component.links.next)
                            },3000)
                        
                    }
                }
                })
            }else{
                this.tags = JSON.parse(this.collection);
            }

        }
    }
</script>
