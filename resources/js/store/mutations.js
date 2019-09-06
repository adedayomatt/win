
let mutations = {
    APP_READY(state, status){
        state.app_ready = status;
    },
    SET_AUTH_USER(state, user){
        state.auth = user;
    },
    LOAD_TAGS(state, tags) {
        state.tags_following = tags;
    },
    ADD_TAG(state, tag) {
        state.tags_following.push(tag)
    },
    REMOVE_TAG(state, tag) {
        state.tags_following.splice(getIndex(state.tags_following, tag), 1)
    }

}
export default mutations