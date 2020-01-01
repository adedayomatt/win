<template>
    <div>
        <input class="global-search form-control no-outline" placeholder="search Insyde Life..."
        v-model.trim="q" @keyup="search" @focus="activateSearch"
        >
        <template v-if="active">
            <div class="search-results-container shadow-md">
                <div class="p-2 search-results-container-header">
                    <span class="float-right closer" @click="closeSearch">&times;</span>
                    <p>{{status}}</p>
                </div>
                <div class="search-results-container-body">
                    <template v-if="q !== ''">
                        <template v-if="loading">
                            <div class="p-5">
                                <loading-one message="searching..."></loading-one>
                            </div>
                        </template>
                        <template v-else>
                            <div class="row">
                                <div class="col-lg-2 my-1">
                                    <div class="result-header px-3 py-2">Tags ({{tags.length}})</div>
                                    <div class="result-wrapper">
                                        <tag v-for="tag in tags" :key="tag.id+Math.random()" :data="tag"></tag>
                                    </div>
                                </div>

                                <div class="col-lg-4 my-1">
                                    <div class="result-header px-3 py-2">Discussions ({{discussions.length}})</div>
                                    <div class="result-wrapper">
                                        <discussion v-for="discussion in discussions" :key="discussion.id+Math.random()" :data="discussion"></discussion>
                                    </div>
                                </div>

                                <div class="col-lg-4 my-1">
                                    <div class="result-header px-3 py-2">Trainings ({{trainings.length}})</div>
                                    <div class="result-wrapper">
                                        <training v-for="training in trainings" :key="training.id+Math.random()" :data="training"></training>
                                    </div>
                                </div>

                                <div class="col-lg-2 my-1">
                                    <div class="result-header px-3 py-2">People ({{users.length}})</div>
                                    <div class="result-wrapper">
                                        <user v-for="user in users" :key="user.id+Math.random()" :data="user"></user>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                </div>
                
            </div>
        </template>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import Tag from './Tag/Tag'
    import Discussion from './Discussion/Discussion'
    import Training from './Training/Training'
    import User from './User/User'
    import LoadingOne from './Assets/LoadingOne'

    export default {
       name: 'global-search',
        data () {
            return {
                q: '',
                tags: [],
                discussions: [],
                trainings: [],
                users: [],
                active: false,
                loading: false,
                status: 'Type above to search'
            }
        },
        props: ['container'],
        computed: {
            ...mapGetters([
                'root',
                'is_following_tag'
            ]),
            input(){
                return `${this.container} input.global-search`
            }
           
        },
        methods: {
            search(){
                if(this.q === ''){
                    this.loading = false;
                    this.status = `Type above to search`;
                }else{
                    this.loading = true;
                     this.status = `Looking up "${this.q}"...`;
                    setTimeout(() => {
                        axios.get(`${this.root}/search?q=${this.q}`)
                        .then(response => {
                            this.tags = response.data.tags;
                            this.discussions = response.data.discussions;
                            this.trainings = response.data.trainings;
                            this.users = response.data.users;
                            this.loading = false;
                            this.status = `Search result for "${this.q}"`
                        })
                        .catch(error => {

                        })
                    }, 2000)
                   
                }
               
            },
            activateSearch(){
                this.active = true;
                $('body').css({'overflow':'hidden'});
                $(this.input).css({'background-color': '#fff'});
            },
            closeSearch(){
                this.active = false;
                $('body').css({'overflow':'auto'});
                $(this.input).css({'background-color': '#f9f9f9'});
            }
        },
        components: {
        Tag, Discussion, Training, User, LoadingOne
        },
        mounted() {
           this.closeSearch();
        }
    }
</script>

<style scoped>
    input.global-search{
        border: 0;
        border-radius: 3px;
    }
    .search-results-container{
            overflow: auto;
            position: absolute;
            z-index:1000000;
            left: 0;
            right: 0;
            background-color: #fff;
        }
    .search-results-container-header{
        position: fixed;
        z-index:1000001;
        left: 0;
        right:0;
        background-color: #fff;
        border-bottom: 1px solid #f7f7f7
        }
    .search-results-container-body{
        padding-top: 60px;
        height: 92vh;
        overflow: auto;
    }
    .result-header{
        background-color: #f7f7f7;
    }
    .result-wrapper{
        max-height: 300px;
        overflow:auto;
    }

    @media (min-width:992px){
        .search-results-container{
            /* height: unset; */
        }
        .result-wrapper{
            max-height: 100%;
        }
    }
</style>