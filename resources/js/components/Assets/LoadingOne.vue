<template>
    <div>
        <div class="loading-container" :style="`background-image: url(${root}/assets/loading-1.gif)`"></div>
        <div class="text-center">
            <p>{{message}}</p>
        </div>
        
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

    export default {
        computed:{
            ...mapGetters([
                'root'
            ])
        },
        props: ['message'],
        watch: {
            message: function(newMessage, oldMessage){
                this.message = newMessage;
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
