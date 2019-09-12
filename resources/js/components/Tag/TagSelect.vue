<template>
    <div id="tag-selection">
         <template v-if="tags.length > 0">
             <small class="text-muted">{{tags.length}} tag selected</small>
            <div class="mt-1">
                <span class="tag" v-for="tag in tags" v-bind:key="tag.id">
                    <span class="float-right closer" @click="removeTag(tag)">&times;</span>
                    <span>{{tag.name}}</span>
                    <input type="hidden" name="tags[]" v-model="tag.id">
                </span>
            </div>
        </template>
        <tag-search container="#tag-selection" purpose="selection" v-bind:already_selected="tags" @tag-selected="tagSelected" ></tag-search>

    </div>
</template>

<script>
import TagSearch from './TagSearch.vue';
export default {
    data(){
        return {
            tags: this.selected
        }
    },
    props: ['selected'],
    methods: {
        tagSelected(tag){
            if(!itemExist(this.tags,tag)){ //check if the tag has not been selected before
                this.tags.push(tag);
            }
        },
        removeTag(tag){
            removeItem(this.tags, tag);
        }
    },
    mounted() {},
    components: {
        TagSearch
    }
}
</script>