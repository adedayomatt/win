let getters = {
    app_ready: state => {
        return state.app_ready
    },
    auth: state => {
        return state.auth
    },
    is_authenticated: state => {
        return state.auth == null ? false : true
    },
    // to compute time difference 
    time_diff: state => timestamp => {
        return timeDiff(timestamp);
    },
    is_trashed: state => item => {
        return item.deleted_at == null ? false : true;
    },
    snippet: state => (content,length = 100) => {
        return content.substring(0,length);
    }
}

export default  getters