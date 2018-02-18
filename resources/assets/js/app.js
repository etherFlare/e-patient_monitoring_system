require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

window.VueRouter=require('vue-router').default;

window.VueAxios=require('vue-axios').default;
 
import Toaster from 'v-toaster'

// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'

window.Axios=require('axios').default;

let AppLayout= require('./components/post/App.vue');

// show the list post template
const Listposts=Vue.component('Listposts', require('./components/post/Listposts.vue'));

// add post template
const Addpost =Vue.component('Addpost', require('./components/post/Addpost.vue'));

// edite post template
const Editpost =Vue.component('Editpost', require('./components/post/Editpost.vue'));

// delete post template
const Deletepost =Vue.component('Deletepost', require('./components/post/Deletepost.vue'));

// view single post template
const Viewpost =Vue.component('Viewpost', require('./components/post/Viewpost.vue'));

const heartBeat =Vue.component('heart-beat', require('./components/heart-beat.vue'));
const vmodal =Vue.component('v-modal', require('./components/modal.vue'));


// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})


// registering Modules
Vue.use(VueRouter,VueAxios, axios, Vuex);
Vue.use(require('vue-moment'));

const routes = [
{
  name: 'Listposts',
  path: '/post',
  component: Listposts
},
{
  name: 'Addpost',
  path: '/post/add-post',
  component: Addpost
},
{
  name: 'Editpost',
  path: '/post/edit/:id',
  component: Editpost
},
{
  name: 'Deletepost',
  path: '/post/post-delete',
  component: Deletepost
},
{
  name: 'Viewpost',
  path: '/post/view/:id',
  component: Viewpost
}
];

const router = new VueRouter({ mode: 'history', routes: routes});

const store = new Vuex.Store({
  state: { 
    loading: true,
    posts: {}
  },
  getters: {
    loading(state) {
      return state.loading
    }, 
    postsCollection(state) {
      return state.posts
    },
    posts(state, getters) {
      return getters.postsCollection.data
    }
  },
  actions: {
    
   async getPosts({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/post/posts/',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.posts, {data: []})
    await dispatch('newPosts', nullData)

    await axios(axiosOptions).then(async (response) => {
      await console.log('getPosts:', response)
      await dispatch('newPosts', response.data)
          setTimeout(()=> commit('setLoading', false), 3000)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newPosts({commit}, payload) {
    commit('setPosts', payload)
  }
},
mutations: { 
  setLoading(state, payload){
    state.loading = payload
  },
  setPosts(state, payload){
    state.posts = payload
  }
}
})

new Vue(
 Vue.util.extend(
 { router, store },
 AppLayout
 )
 ).$mount('#app');