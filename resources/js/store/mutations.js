
let mutations = {
    APP_READY(state, status){
        state.app_ready = status;
    },
    SET_AUTH_USER(state, user){
        state.auth = user;
    },

}
export default mutations