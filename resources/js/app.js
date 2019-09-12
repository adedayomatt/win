
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import store from './store/index';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('init', require('./components/init.vue').default);
Vue.component('loading-one', require('./components/Assets/LoadingOne.vue').default);
Vue.component('feeds', require('./components/Feed/Feeds.vue').default);
Vue.component('global-search', require('./components/GlobalSearch.vue').default);
Vue.component('forum-search', require('./components/Forum/ForumSearch.vue').default);

Vue.component('tag', require('./components/Tag/Tag.vue').default);
Vue.component('tags', require('./components/Tag/Tags.vue').default);
Vue.component('tag-search', require('./components/Tag/TagSearch.vue').default);
Vue.component('tag-select', require('./components/Tag/TagSelect.vue').default);
Vue.component('tag-suggest', require('./components/Tag/TagSuggest.vue').default);
Vue.component('tag-follow-btn', require('./components/Tag/TagFollowButton.vue').default);

Vue.component('user', require('./components/User/User.vue').default);
Vue.component('users', require('./components/User/Users.vue').default);
Vue.component('user-search', require('./components/User/UserSearch.vue').default);

Vue.component('discussion', require('./components/Discussion/Discussion.vue').default);
Vue.component('discussions', require('./components/Discussion/Discussions.vue').default);
Vue.component('discussion-meta', require('./components/Discussion/DiscussionMeta.vue').default);
Vue.component('discussion-search', require('./components/Discussion/DiscussionSearch.vue').default);
Vue.component('discussion-comments', require('./components/Discussion/DiscussionComments.vue').default);

Vue.component('training', require('./components/Training/Training.vue').default);
Vue.component('trainings', require('./components/Training/Trainings.vue').default);
Vue.component('training-meta', require('./components/Training/TrainingMeta.vue').default);
Vue.component('training-search', require('./components/Training/TrainingSearch.vue').default);

Vue.component('comment', require('./components/Comment/Comment.vue').default);
Vue.component('comments', require('./components/Comment/Comments.vue').default);
Vue.component('comment-reply', require('./components/Comment/CommentReply.vue').default);
Vue.component('comment-textarea', require('./components/Comment/CommentTextarea.vue').default);

Vue.component('school-search', require('./components/School/SchoolSearch.vue').default);
Vue.component('company-search', require('./components/Company/CompanySearch.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
