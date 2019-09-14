let actions = {
    
    getAuth({commit, dispatch}){ 
        return new Promise((resolve, reject) => {
            if(window.user_token !== ''){
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
    loadFeeds({commit}, url){
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {
                   resolve(response);
                })
                .catch(error => {
                    toastError(error.response);
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
                    toastError(error.response);
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
                    toastError(error.response);
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
                toastError(error.response);
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
                toastError(error.response);
                reject(error);
            })
        });
    },

    postComment({commit},comment){
        let endpoint = null;
        let data = null;
        return new Promise((resolve, reject) => {
            // if the comment is directly to a discussion
            if(comment.discussion != null){
                endpoint = apiURL(`/discussion/${comment.discussion}/comment`);
                data = {
                    comment: comment.content
                }
            }
            // if it's a reply to a comment
            else if (comment.comment != null){ 
                endpoint = apiURL(`/comment/${comment.comment}/reply`);
                data = {
                    parent_comment: comment.comment,
                    comment: comment.content
                }
            }
            if(endpoint != null && data != null){
                axios.post(endpoint,data)
                .then(response => {
                 console.log(response);
                   resolve(response);
                })
                .catch(error => {
                    toastError(error.response);
                    reject(error)
                })
            }
        })
      
   },
    loadComment({commit}, id){
        return new Promise((resolve, reject) => {
            axios.get(apiURL(`/comment/${id}`))
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    toastError(error.response);
                    reject(error)
                })
        })

    },

    likeComment({commit},comment){
        return new Promise((resolve, reject) => {
           axios.post(apiURL(`/comment/${comment.id}/like`))
               .then(response => {
                  resolve(response);
               })
               .catch(error => {
                   toastError(error.response);
                   reject(error)
               })
        })
      
   },

}

export default actions