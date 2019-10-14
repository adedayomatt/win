<template>
   <div class="d-flex py-1">
       <img :src="user.image.src" :alt="user.image.alt" class="avatar avatar-sm">
        <div class="ml-2 pt-1" >
            <strong class="d-block">{{`${user.fullname}`}}</strong>
            <a :href="`/@${user.username}`">@{{user.username}}</a>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
        data(){
            return {
               user: this.data
            }
        },
        computed: {
             ...mapGetters([
                'auth',
                'time_diff',
                'snippet',
            ]),
            
        },
        props: ['data'],
        methods:{

        },
        components:{

},
    mounted() {
        },
    watch: {
        data: function(newData, oldData){
            this.user = newData;
        }
    }    
    }
</script>

<style scoped>

</style>
