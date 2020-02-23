<template>
    <div>
        <template v-if="loading_error == null">
            <div class="loading-container" :style="`background-image: url(${root}/assets/loading-1.gif)`"></div>
            <div class="text-center">
                <p>{{message}}</p>
            </div>
        </template>
        <template v-else>
            <div class="text-center py-5">
                <template v-if="!loading_error.response">
                    <div class="text-muted">Oops! Looks like network isn't good enough</div>
                </template>
                <template v-else>
                    <div class="text-muted">Oops! Something isn't right: {{loading_error.response.statusText}}</div>
                </template>
                <button class="btn btn-default" @click="retry"><i class="fa fa-reset"></i>Retry</button>
            </div>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

    export default {
        data(){
            return {
                loading_error: null,
            }
        },
        computed:{
            ...mapGetters([
                'root'
            ])
        },
        methods:{
            retry(){
                this.$emit('retry');
            }
        },
        props: ['message', 'error'],
        mounted(){
            this.loading_error = this.error
        },
        watch: {
            message: function(new_message, old_message){
                this.message = new_message;
            },
            error: function(new_error, old_error){
                this.loading_error= new_error;
            }
        }
    }
</script>

<style scoped>
    .loading-container{
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 80px 80px;
        height: 90px
    }
</style>
