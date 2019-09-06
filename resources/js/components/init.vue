<template>
    <div v-if="!app_ready" class="loader-parent">
    </div>
</template>

<script>
// this component is to initiate the app states, it  will be mounted at the topmost of the page
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

    export default {
        data(){
            return {
                // completed: false
            }
        },
         computed: {
             ...mapGetters([
               'app_ready'
            ]),
         },
        methods:{
            ...mapActions([
            'getAuth',
            ]),

        },
        mounted() {
                this.getAuth()
                .then(response => {
                
                })
                .catch(err =>{

                });
        }
    }
</script>

<style scoped>
    .loader-parent{
        background-color: rgba(0,0,0,.2);
        width: 100%;
        height: 100vh;
        position: fixed;
        z-index: 1000000;
    }
</style>

