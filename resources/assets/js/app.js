require('./bootstrap'); 

window.Vue = require('vue');
window.Vuex = require('vuex');

window.VueRouter=require('vue-router').default;

window.VueAxios=require('vue-axios').default;
 
import Toaster from 'v-toaster'

import * as uiv from 'uiv'
 
// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'

import NewPostModalComponent from './components/post/new-post-modal.vue'
import EditPostModalComponent from './components/post/edit-post-modal.vue'
import DeletePostModalComponent from './components/post/delete-post-modal.vue'

import NewUnitModalComponent from './components/unit/new-unit-modal.vue'
import EditUnitModalComponent from './components/unit/edit-unit-modal.vue'
import DeleteUnitModalComponent from './components/unit/delete-unit-modal.vue'

import NewRoleModalComponent from './components/role/new-role-modal.vue'
import EditRoleModalComponent from './components/role/edit-role-modal.vue'
import DeleteRoleModalComponent from './components/role/delete-role-modal.vue'

import NewUserModalComponent from './components/user/new-user-modal.vue'
import EditUserModalComponent from './components/user/edit-user-modal.vue'
import DeleteUserModalComponent from './components/user/delete-user-modal.vue'

import NewPatientModalComponent from './components/patient/new-patient-modal.vue'
import EditPatientModalComponent from './components/patient/edit-patient-modal.vue'
import DeletePatientModalComponent from './components/patient/delete-patient-modal.vue'

import NewLocationModalComponent from './components/location/new-location-modal.vue'
import EditLocationModalComponent from './components/location/edit-location-modal.vue'
import DeleteLocationModalComponent from './components/location/delete-location-modal.vue'

import NewTypeModalComponent from './components/type/new-type-modal.vue'
import EditTypeModalComponent from './components/type/edit-type-modal.vue'
import DeleteTypeModalComponent from './components/type/delete-type-modal.vue'

import NewNormalModalComponent from './components/normal/new-normal-modal.vue'
import EditNormalModalComponent from './components/normal/edit-normal-modal.vue'
import DeleteNormalModalComponent from './components/normal/delete-normal-modal.vue'

window.Axios=require('axios').default;

let AppLayout= require('./components/app.vue');
 
// show the list post template
const Listposts=Vue.component('Listposts', require('./components/post/list-post.vue'));
 // show the list unit template
const Listunits=Vue.component('Listunits', require('./components/unit/list-unit.vue'));
// show the list role template
const Listroles=Vue.component('Listroles', require('./components/role/list-role.vue'));
// show the list user template
const Listusers=Vue.component('Listusers', require('./components/user/list-user.vue'));
// show the list patient template
const Listpatients=Vue.component('Listpatients', require('./components/patient/list-patient.vue'));
// show the list location template
const Listlocations=Vue.component('Listlocations', require('./components/location/list-location.vue'));
// show the list type template
const Listtypes=Vue.component('Listtypes', require('./components/type/list-type.vue'));
// show the list normal template
const Listnormals=Vue.component('Listnormals', require('./components/normal/list-normal.vue'));
// show the list metadata template
const Listmetadatas=Vue.component('Listmetadatas', require('./components/metadata/list-metadata.vue'));
// show the list post template
const Observepatients=Vue.component('Observepatients', require('./components/observe/observe-patient.vue'));

const heartBeat =Vue.component('heart-beat', require('./components/heart-beat.vue'));
const vmodal =Vue.component('v-modal', require('./components/modal.vue'));

// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})
Vue.use(uiv)

// registering Modules
Vue.use(VueRouter,VueAxios, axios, Vuex);
Vue.use(require('vue-moment'));

Vue.component('new-post-modal', NewPostModalComponent);
Vue.component('edit-post-modal', EditPostModalComponent);
Vue.component('delete-post-modal', DeletePostModalComponent);

Vue.component('new-unit-modal', NewUnitModalComponent);
Vue.component('edit-unit-modal', EditUnitModalComponent);
Vue.component('delete-unit-modal', DeleteUnitModalComponent);

Vue.component('new-role-modal', NewRoleModalComponent);
Vue.component('edit-role-modal', EditRoleModalComponent);
Vue.component('delete-role-modal', DeleteRoleModalComponent);

Vue.component('new-user-modal', NewUserModalComponent);
Vue.component('edit-user-modal', EditUserModalComponent);
Vue.component('delete-user-modal', DeleteUserModalComponent);

Vue.component('new-patient-modal', NewPatientModalComponent);
Vue.component('edit-patient-modal', EditPatientModalComponent);
Vue.component('delete-patient-modal', DeletePatientModalComponent);

Vue.component('new-location-modal', NewLocationModalComponent);
Vue.component('edit-location-modal', EditLocationModalComponent);
Vue.component('delete-location-modal', DeleteLocationModalComponent);

Vue.component('new-type-modal', NewTypeModalComponent);
Vue.component('edit-type-modal', EditTypeModalComponent);
Vue.component('delete-type-modal', DeleteTypeModalComponent);

Vue.component('new-normal-modal', NewNormalModalComponent);
Vue.component('edit-normal-modal', EditNormalModalComponent);
Vue.component('delete-normal-modal', DeleteNormalModalComponent);

const routes = [
{
  name: 'Listposts',
  path: '/post',
  component: Listposts
},
{
  name: 'Listunits',
  path: '/unit',
  component: Listunits
},
{
  name: 'Listroles',
  path: '/role',
  component: Listroles
},
{
  name: 'Listusers',
  path: '/user',
  component: Listusers
},
{
  name: 'Listpatients',
  path: '/patient',
  component: Listpatients
},
{
  name: 'Listlocations',
  path: '/location',
  component: Listlocations
},
{
  name: 'Listtypes',
  path: '/type',
  component: Listtypes
},
{
  name: 'Listnormals',
  path: '/normal',
  component: Listnormals
},
{
  name: 'Listmetadatas',
  path: '/metadata',
  component: Listmetadatas
},
{
  name: 'Observepatients',
  path: '/observe',
  component: Observepatients
}
];

const router = new VueRouter({ mode: 'history', routes: routes});

const store = new Vuex.Store({
  state: { 
    loading:  true,
    posts:    {},
    units:    {},
    roles:    {},
    users:    {},
    patients: {},
    locations:{},
    types:    {},
    normals:  {},
    metadatas:{},
    observe:{}
  },
  getters: {
    loading(state) {
      return state.loading
    }, 
    postsCollection(state) {
      return state.posts
    },
    posts(state, getters) {
      return getters.postsCollection
    },
    //-------------------------units
    unitsCollection(state) {
      return state.units
    },
    units(state, getters) {
      return getters.unitsCollection.data
    },
    //-------------------------role
    rolesCollection(state) {
      return state.roles
    },
    roles(state, getters) {
      return getters.rolesCollection.data
    },
    //-------------------------user
    usersCollection(state) {
      return state.users
    },
    users(state, getters) {
      return getters.usersCollection.data
    },
    //-------------------------patitient
    patientsCollection(state) {
      return state.patients
    },
    patients(state, getters) {
      return getters.patientsCollection.data
    },
    //-------------------------palocation
    locationsCollection(state) {
      return state.locations
    },
    locations(state, getters) {
      return getters.locationsCollection.data
    },
     //-------------------------type
    typesCollection(state) {
      return state.types
    },
    types(state, getters) {
      return getters.typesCollection.data
    },
     //-------------------------normal
    normalsCollection(state) {
      return state.normals
    },
    normals(state, getters) {
      return getters.normalsCollection.data
    },
    //-------------------------metadata
    metadatasCollection(state) {
      return state.metadatas
    },
    metadatas(state, getters) {
      return getters.metadatasCollection.data
    }
    //-------------------------
  },
  actions: {
    
   async getPosts({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/post/posts',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.posts, {data: []})
    await dispatch('newPosts', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getPosts:', response)
      await dispatch('newPosts', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newPosts({commit}, payload) {
    commit('setPosts', payload)
  },
//--------------------------units
async getUnits({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/unit/units',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.units, {data: []})
    await dispatch('newUnits', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getUnits:', response)
      await dispatch('newUnits', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newUnits({commit}, payload) {
    commit('setUnits', payload)
  },
  //--------------------------roles
async getRoles({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/role/roles',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.roles, {data: []})
    await dispatch('newRoles', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getRoles:', response)
      await dispatch('newRoles', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newRoles({commit}, payload) {
    commit('setRoles', payload)
  },
//--------------------------user
async getUsers({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/user/users',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.users, {data: []})
    await dispatch('newUsers', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getUsers:', response)
      await dispatch('newUsers', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newUsers({commit}, payload) {
    commit('setUsers', payload)
  },
  //--------------------------patient
async getPatients({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/patient/patients',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.patients, {data: []})
    await dispatch('newPatients', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getPatients:', response)
      await dispatch('newPatients', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newPatients({commit}, payload) {
    commit('setPatients', payload)
  },
  //--------------------------location
async getLocations({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/location/locations',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.locations, {data: []})
    await dispatch('newLocations', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getLocations:', response)
      await dispatch('newLocations', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newLocations({commit}, payload) {
    commit('setLocations', payload)
  },
  //--------------------------type
async getTypes({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/type/types',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.types, {data: []})
    await dispatch('newTypes', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getTypes:', response)
      await dispatch('newTypes', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newTypes({commit}, payload) {
    commit('setTypes', payload)
  },
  //--------------------------type
async getNormals({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/normal/normals',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    let nullData = Object.assign(state.normals, {data: []})
    await dispatch('newNormals', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getNormals:', response)
      await dispatch('newNormals', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newNormals({commit}, payload) {
    commit('setNormals', payload)
  },
   //--------------------------type
async getMetadatas({commit, dispatch, state}, data) {
    data = data || {}
    const axiosOptions = {
      'url': '/metadata/metadatas',
      'method': 'get',
      'params': data
    }
    await commit('setLoading', true)
    // let nullData = Object.assign(state.metadatas, {data: []})
    // await dispatch('newMetadatas', nullData)

    return await axios(axiosOptions).then(async (response) => {
      await console.log('getMetadatas:', response)
      await dispatch('newMetadatas', response.data)
       commit('setLoading', false)

    }).catch(error => { 
      console.log('error', error); 
    })
  },
  newMetadatas({commit}, payload) {
    commit('setMetadatas', payload)
  }
  //-------------------------------------------
},
mutations: { 
  setLoading(state, payload){
    state.loading = payload
  },
  setPosts(state, payload){
    state.posts = payload
  },
  setUnits(state, payload){
    state.units = payload
  },
  setRoles(state, payload){
    state.roles = payload
  },
  setUsers(state, payload){
    state.users = payload
  },
  setPatients(state, payload){
    state.patients = payload
  },
  setLocations(state, payload){
    state.locations = payload
  },
  setTypes(state, payload){
    state.types = payload
  },
  setNormals(state, payload){
    state.normals = payload
  },
  setMetadatas(state, payload){
    state.metadatas = payload
  }
} 
})

new Vue(
 Vue.util.extend(
 { router, store },
 AppLayout
 )
 ).$mount('#app');