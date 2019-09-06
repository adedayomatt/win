<template>
    <span>
        <span v-for="user in users" :key="user.id" >
            <a v-if="auth == null || user.id != auth.id" href="#" >, 
                <img :src="user.image" alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px; border: 2px solid #fff" data-toggle="tooltip" :title="user.username">
            </a>
        </span>
    </span>
</template> 

<script>
import {mapGetters} from 'vuex';

    export default {
        data(){
            return{
            users: this.prop_users,
            } 
        },
        computed: {
            ...mapGetters([
                'app_ready',
                'auth',
            ]),
        },
        props:['prop_users'],
        methods: {

        },
        mounted(){

        }
        
}
</script>