<template>
    <span>
        <span class="ml-2">
            <span v-if="am_among" class="mr-3" @click="userClicked(auth)">You, </span>
            <span v-for="user in showing" :key="user.id+Math.random()" >
                <a v-if="!is_authenticated || (auth.id != user.id)" class="users-component" :href="`/@${user.username}`" @click.prevent="userClicked(user)" data-toggle="tooltip" :data-content="userPopover(user)" :title="user.fullname">
                    <img :src="user.image.src" :alt="user.image.alt" style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px; border: 2px solid #fff" >
                </a>
            </span>
        </span>
        <a href="#" class="text-muted" v-if="others > 0" @click.prevent="showMore"> +{{others}} others</a>
    </span>
</template> 

<script>
import {mapGetters} from 'vuex';

    export default {
        data(){
            return{
            users: this.data,
            showing: [],
            max: this.chunk || 3,
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
            },
            others(){
                return this.users.length - this.showing.length
            },
        },
        props:['data','chunk'],
        methods: { 
            userClicked(user){
                this.$emit('user-clicked',user);
            },
            computeData(data){
                this.users = data;
                this.showing = this.showing.concat(this.loadBatch())
            },
            loadBatch(){
                let start = this.showing.length;
                let end = start+this.max;
                return this.users.slice(start,end);
            },
            showMore(){
               this.showing = this.showing.concat(this.loadBatch())
            },
            userPopover(user){
                    return `
                       <div class="d-flex py-1">
                            <img src="${user.image.src}" alt="${user.image.alt}" class="avatar avatar-sm">
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
            this.computeData(this.data);
              $('[data-toggle="popover"]').popover({
                    html: true,
                    trigger: 'hover',
                    placement: 'top'        
                })
        },
        watch: {
            data: function(newData,oldData){
                this.computeData(newData);
            }
        }
        
}
</script>

<style scoped>
    .users-component{
        cursor: pointer;
    }
</style>