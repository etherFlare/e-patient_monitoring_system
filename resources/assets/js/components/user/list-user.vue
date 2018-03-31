<template id="user-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateUserModalComponent($event)"><span class="glyphicon glyphicon-plus"></span> Add new User</a>
            </div>
          </div>
          <form v-on:submit.prevent="getUsers($event)">
            <div class="form-inline">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" v-model="searchTerm"/>
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">search</button>
                  </div>
                </div>
              </div>
            </div>
            <p>{{searchTerm}}</p>
          </form>
        </div>
        <div class="box-body">
          <div v-if="!loading">
            <table  id="ex1" class="table table-bordered table-hover">
              <thead v-if="users.length">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Date Created</th>
                  <th>Roles</th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" >
                  <td v-on:click="showUserModalComponent($event, user)">{{ user.last_name }}, {{ user.first_name }} {{ user.middle_name }}</td>
                  <td v-on:click="showUserModalComponent($event, user)">{{ user.email }}</td>
                  <td v-on:click="showUserModalComponent($event, user)">{{ user.created_at | moment('LLLL')}} <code>{{ user.created_at | moment('from')}}</code></td>
                  <td>
                    <div v-for="(role, rolesIdx) in user.roles" :key="rolesIdx">{{role.title}}</div>
                    <span v-if="!user.roles.length">--</span>
                  </td>
                  <td class="row">
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showUserModalComponent($event, user)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!users.length">
                  <td colspan="5" class="text-center">
                    <p class="no-margin text-red">{{searchTerm}} was not in the list</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
          <pagination v-model="currentPage" :total-page="totalPage" align="center" :max-size="3"/>
        </div>
        <new-user-modal ref="showCreateUserModal" v-if="showCreateUserModal" v-on:close="showCreateUserModal = false" v-on:user-created="userCreated" ></new-user-modal>
        <edit-user-modal v-if="showEditUserModal" v-on:close="showEditUserModal = false" :edit-user="user" v-on:user-updated="getUsers"></edit-user-modal>
        <delete-user-modal ref="showDeleteUserModal" :delete-user="user" v-if="showDeleteUserModal" v-on:user-deleted="getUsers" v-on:close="showDeleteUserModal = false"  v-on:deleted="showUserModal = false" ></delete-user-modal>
        <modal ref="showUserModal" v-model="showUserModal" auto-focus v-on:hide="$emit('close')">
          <template v-if="user">
          <div slot="title" >
            <div class="box-profile row">
              <img class="animated-box profile-user-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="User profile picture" style="margin-right:50px">
              <h3 class="profile-username text-center"> {{ user.last_name }}, {{ user.first_name }} {{ user.middle_name }}</h3>
              <p class="text-muted text-center">{{ Object.keys(user.roles).map(key=>user.roles[key].title).join(' | ') }}</p>
            </div>
          </div>
          <div class="box-body">
            <strong><i class="fa fa-mobile-phone margin-r-5"></i> Contact Number</strong>
            <p class="text-muted">{{ user.contact_number }}</p>
            <hr>
            <strong><i class="fa  fa-user-plus margin-r-5"></i>Account Created Since</strong>
            <div class="text-muted">{{user.created_at | moment('LLLL')}}</div>
            <code>{{user.created_at | moment('from')}}</code>
            <hr>
            <strong><i class="fa fa-calendar-check-o margin-r-5"></i>Date Updated </strong>
            <div class="text-muted">{{user.updated_at | moment('LLLL')}}</div>
            <code>{{user.updated_at | moment('from')}}</code>
            <hr>
            <strong><i class="fa fa-file-text-o margin-r-5"></i> Comment</strong>
            <p>{{ user.comment }}</p>
          </div>
          <div slot="footer">
            <btn type="warning"  class="" v-on:click="showEditUserModalComponent($event, user)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
            <btn type="danger"  class="" v-on:click="showDeleteUserModalComponent($event, user)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
            <btn  v-on:click="showUserModal=false" data-action="auto-focus">Cancel</btn>
          </div>
        
          </template>
        </modal>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      on_load: true,
      user: null,
      showCreateUserModal: false,
      showEditUserModal: false,
      showDeleteUserModal: false,
      showUserModal: false,
      searchTerm: '',
      totalPage: 18,
      currentPage: 1
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getUsers().then((response)=>{
        this.on_load = false
      })
    })
  },
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    users() {
      return this.$store.getters.users
    },
    filteredUsers: function(){
      if(this.users.length) {
        return this.users;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    userCreated() {
      this.getUsers()
    },
    showCreateUserModalComponent(event) {
      this.showCreateUserModal = true
    },
    showEditUserModalComponent(event, user) {
      this.user = user
      this.$nextTick(() => {
        this.showEditUserModal = true
      })
    },
    showDeleteUserModalComponent(event, user) {
      this.user = user
      this.$nextTick(() => {
        this.showDeleteUserModal = true
      })
    },
    showUserModalComponent(event, user) {
      this.user = user
      this.$nextTick(() => {
        this.showUserModal = true
      })
    },
    getUsers(event) {
      return this.$store.dispatch('getUsers', { 'search': this.searchTerm })
    }
  }
}
</script>
