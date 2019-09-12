<template>
    <span >
        <span v-if="am_among" class="mr-2" @click="userClicked(auth)" data-toggle="popover" :data-content="userPopover(auth)">You, </span>
        <span v-for="user in users" :key="user.id" >
            <a v-if="auth == null || user.id != auth.id" :href="`/@${user.username}`" @click.prevent="userClicked(user)">, 
                <img :src="user.image" alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-left: -15px; border: 2px solid #fff"  data-toggle="popover" :data-content="userPopover(user)">
            </a>
        </span>
    </span>
</template> 

<script>
import {mapGetters} from 'vuex';

    export default {
        data(){
            return{
            users: this.data,
            } 
        },
        computed: {
            ...mapGetters([
                'app_ready',
                'auth',
                'is_authenticated'
            ]),
            am_among(){
                if(this.is_authenticated){
                    return this.users.findIndex(user =>  user.id == this.auth.id) < 0 ? false : true;
                }
                return false;
            }
        },
        props:['data'],
        methods: { 
            userClicked(user){
                this.$emit('user-clicked',user);
            },
            userPopover(user){
                    return `
                       <div class="d-flex py-1">
                            <img src="${user.image}" class="avatar avatar-sm">
                            <div class="ml-2 pt-1" >
                                <strong class="d-block">${user.fullname}</strong>
                                <a href="/@${user.username}">@${user.username}</a>
                                ${user.bio == null ? '' : '<div class="text-muted">'+user.bio+'</div>'}
                            </div>
                        </div>
                  `
            }
        },
        mounted(){
            $('[data-toggle="popover"]').popover({
                html: true,
                trigger: 'click hover',      
                position: 'top'  
            })

        },
        watch: {
            data: function(newData,oldData){
                this.users = newData;
            }
        }
        
}
</script>