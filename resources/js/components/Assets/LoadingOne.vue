<template>
    <div>
        <div class="loading-container"></div>
        <div class="text-center">
            <p>{{message}}</p>
        </div>
        
    </div>
</template>

<script>

    export default {
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
        background-image: url('/assets/loading-1.gif');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 80px 80px;
        height: 90px
    }
</style>
