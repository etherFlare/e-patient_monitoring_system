<template id="user-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateUserModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new User</a>
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
          <heart-beat v-if="on_load"></heart-beat>
          <div v-if="!loading"> 
            <table  id="ex1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users">
                  <td>{{ index + 1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.created_at | moment('LLLL')}} <code>{{ user.created_at | moment('from')}}</code></td>
                  <td>{{ user.updated_at }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-3" style="margin-left:3px;margin-right:3px;" v-on:click="showUserModalComponent($event, user)"><i class="fa fa-eye"></i> Show</btn>
                    <btn size="xs" type="warning"  class="col-xs-3"style="margin-left:3px;margin-right:3px;" v-on:click="showEditUserModalComponent($event, user)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
                    <btn size="xs" type="danger"  class="col-xs-3" style="margin-left:3px;margin-right:3px;"  v-on:click="showDeleteUserModalComponent($event, user)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-user-modal ref="showCreateUserModal" v-if="showCreateUserModal" v-on:close="showCreateUserModal = false" v-on:user-created="userCreated" ></new-user-modal>
        <edit-user-modal v-if="showEditUserModal" v-on:close="showEditUserModal = false" :edit-user="user" v-on:user-updated="getUsers"></edit-user-modal> 
        <delete-user-modal ref="showDeleteUserModal" :delete-user="user" v-if="showDeleteUserModal" v-on:user-deleted="getUsers" v-on:close="showDeleteUserModal = false"></delete-user-modal>

        <!--show modal-->
        <modal ref="showUserModal" v-if="showUserModal" v-model="showUserModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">USER</h3>       
          <strong>{{ user.name }}</strong>
          <p>{{ user.email }}</p> 
          <div>{{user.created_at | moment('LLLL')}}</div>
          <code>{{user.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditUserModalComponent($event, user)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeleteUserModalComponent($event, user)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showUserModal=false" data-action="auto-focus">Cancel</btn>
          </div>
        </modal>
        <!--show modal end-->
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
        this.showDeletePostModal = true
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
  },
}
</script>
