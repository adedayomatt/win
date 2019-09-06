<template>
    <div>
        <button type="button" :class="btn_class" @click="follow">{{text}}</button>
        <div class="text-center">
            <small class="text-muted d-block">{{status}}</small>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';

export default {
    name: 'tag-follow-btn',
    data(){
        return {
            tag: this.prop_tag,
            text: '...',
            status: '',
            btn_class: 'btn btn-default'
        }
    },
    props:['prop_tag'],
    computed: {
        ...mapGetters([
            'tags_following',
            'is_following_tag'
        ]),
    },
    methods: {
        ...mapActions([
            'followTag'
        ]),
        checkFollow(){
            if(itemExist(this.tags_following,this.tag)){
                this.following()
            }else{
                 this.notFollowing()
            }
        },
        follow(){
            this.followTag(this.tag)
            .then(response => {
                if(response.data.action == 'follow'){
                    this.following();
                    toastr.success(`Now following ${this.tag.name}`);
                    this.$emit('tag-followed', response.data.tag);
                }else if(response.data.action == 'unfollow'){
                    this.notFollowing();
                    toastr.success(`You no longer follow ${this.tag.name}`);
                    this.$emit('tag-unfollowed', response.data.tag);
                }
            })
            .catch(error => {
                this.failed('failed!');
            })
            .finally(()=>{
                //alert(response.message);
            })
            
        },
        following(){ 
            this.text = 'unfollow';
            this.btn_class = 'btn btn-sm btn-default';
            this.status = 'following';

        },
        notFollowing(){
            this.text = 'follow';
            this.btn_class = 'btn btn-sm btn-primary'
        },
        failed(status =''){
            this.status = status;
        }
    },
    mounted(){
        this.checkFollow();
    }
}
</script>