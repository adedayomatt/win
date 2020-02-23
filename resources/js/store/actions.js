let actions = {
    
    getAuth({commit, dispatch}){ 
        return new Promise((resolve, reject) => {
            if(window.key !== ''){
                axios.get(apiURL('/user'))
                .then(res => {
                    console.log(res);
                    if(res.data != null){
                        commit('SET_AUTH_USER', res.data);
                        commit('APP_READY', true);
                    }
                    resolve(res)
                })
                .catch(err => {
                    toastError(err.response);
                    reject(err)
                })
            }   
            else{
                commit('APP_READY', true)
            } 
        });
    },

    apiCall({commit}, param = {endpoint: '', method: 'GET', api: true, data: {}}){
        console.log(param);

        return new Promise((resolve, reject) => {
            let endpoint = param.endpoint == undefined ? '' : param.endpoint;
            let method = param.method == undefined ? 'GET' : param.method;
            let api = param.api == undefined ? true : param.api;
            let data = param.data == undefined ? {} : param.data;
            let request = null;
            if(api === true){
               endpoint = apiURL(endpoint)
            }
            switch(method){
                case 'GET':
                    request = axios.get(endpoint, data);
                break;
                case 'POST':
                    request = axios.post(endpoint, data);
                break;
                case 'PUT':
                    request = axios.put(endpoint, data);
                break;
                case 'DELETE':
                    request = axios.delete(endpoint, data);
                break;
            }
            if(request !== null){
                request.then(response => {
                resolve(response);
                })
                .catch(error => {
                    toastError(error);
                    reject(error)
                })
            }
        })
    },
    loadUser({commit}, username){
        return new Promise((resolve, reject) => {

            axios.get(apiURL(`/user/${username}`))
                .then(response => {
                   resolve(response);
                })
                .catch(error => {
                    if(error.response.status == 404){
                        toastr.error(`user <strong>@${username}</strong> not found`)
                    }
                    reject(error)
                })
         })
 
    },   
    loadMyTags({commit}) {
       return new Promise((resolve, reject) => {
                axios.get(apiURL(`/my_tags`))
                .then(res => {
                    resolve(res);
                }).catch(error => {
                    toastError(error);
                    reject(error);
            })
       })
    },
    loadSuggestionTags({commit, dispatch}) {
        return new Promise((resolve, reject) => {
                 axios.get(apiURL(`/tag_suggestions`))
                 .then(res => {
                     resolve(res);
                 }).catch(error => {
                    toastError(error);
                    reject(error);
             })
        })
     },
     createNewTag({commit, dispatch},name){
         return new Promise((resolve, reject) => {
            axios.post(apiURL('/tag'), {name: name})
            .then((response) => {
                commit('ADD_TAG', response.data);
                resolve(response);
            })
            .catch((error) =>{
                toastError(error);
                reject(error);
            })
            
         });
    },
    followTag({commit, dispatch}, tag) {
        return new Promise((resolve, reject) => {
            axios.post(apiURL(`/tag/${tag.id}/follow`))
            .then(response => {
                resolve(response);  // Let the calling function know that http is done.
            })
            .catch(error => {
                toastError(error);
                reject(error);
            })
        });
    },

}

export default actions