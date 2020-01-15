let getters = {
    root: state => {
        return baseURL()
    },
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
    },
    makeId: state => (prefix = '', suffix = '', random_length = 5) => {
        return `${prefix}${randomChar(random_length)}${suffix}`;
    },  
    renderHTML: state => (container, string) => {
        // console.log('rendering in '+container);
        $('#'+container).html($.parseHTML(string));
    },
    getMentions: state => (content) => {
        let ats = getIndicesOf(' @', content);
        let mentions = [];
        if(ats.length > 0){
           ats.forEach(index => {
               var snippet = content.substring(index).slice(1);
               var username = snippet.split(' ')[0];
               mentions.push(username);
           });
       }
       return mentions;
    },
    resolveMentions: state => (content, mentions = []) => {
        mentions.forEach(mention => {
           content = content.replace(' '+mention, ' <a href="'+baseURL()+'/'+mention+'">'+mention+'</a>')
        })
        return content;
    }
   
}

export default  getters