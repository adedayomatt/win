<template>
    <div v-if="app_ready">
        <button v-if="following" type="button" class="btn btn-sm btn-primary no-outline follow-btn" @click="follow">following</button>
        <button v-else type="button" class="btn btn-sm btn-default no-outline follow-btn" @click="follow">follow</button>
        <div class="text-center">
            <small class="text-muted d-block">{{status}}</small>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
import { type } from 'os';

export default {
    name: 'tag-follow-btn',
    data(){
        return {
            tag: this.prop_tag,
            status: '',
        }
    },
    props:['prop_tag'],
    computed: {
        ...mapGetters([
            'auth',
            'app_ready',
            'is_authenticated'
        ]),
        following(){
            if(this.auth !== null){
                return itemExist(this.tag.users,this.auth)
            }
            return false;
        }
    },
    methods: {
        ...mapActions([
            'followTag'
        ]),

        follow(){
            this.followTag(this.tag)
            .then(response => {
                if(response.data.action == 'follow'){
                    this.tag.users.push(this.auth);
                    toastr.success(`Now following ${this.tag.name}`);
                    this.$emit('tag-followed', response.data.tag);
                }else if(response.data.action == 'unfollow'){
                    this.tag.users.splice(getIndex(this.tag.users,this.auth),1);
                    toastr.success(`You no longer follow ${this.tag.name}`);
                    this.$emit('tag-unfollowed', response.data.tag);
                }
            })
            .catch(error => {
                this.status = 'failed!';
            })
            .finally(()=>{
                //alert(response.message);
            })
            
        },
    },
    mounted(){
            //this.checkFollow();
    },
    watch: {
        prop_tag: function(newData, newdata){
            this.checkFollow();
        }
    }
}
</script>

<style scoped>
.follow-btn{
    border: 1px solid #f7f7f7;
    border-radius: 5px;
}
</style>