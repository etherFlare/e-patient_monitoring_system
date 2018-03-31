<template id="role-list">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateRoleModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Role</a>
            </div>
          </div>  
          <form v-on:submit.prevent="getRoles($event)">
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
                  <th>Title</th>
                  <th class="col-md-2"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(role, index) in roles" >
                  <td v-on:click="showRoleModalComponent($event, role)">{{ role.title }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showRoleModalComponent($event, role)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!roles.length">
                  <td colspan="2" class="text-center">
                    <p class="no-margin text-red">{{searchTerm}} was not in the list</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-role-modal ref="showCreateRoleModal" v-if="showCreateRoleModal" v-on:close="showCreateRoleModal = false" v-on:role-created="roleCreated" ></new-role-modal>
        <edit-role-modal v-if="showEditRoleModal" v-on:close="showEditRoleModal = false" :edit-role="role" v-on:role-updated="getRoles"></edit-role-modal> 
        <delete-role-modal ref="showDeleteRoleModal" :delete-role="role" v-if="showDeleteRoleModal" v-on:role-deleted="getRoles" v-on:close="showDeleteRoleModal = false"  v-on:deleted="showRoleModal = false" ></delete-role-modal>

        <!--show modal-->
        <modal ref="showRoleModal" v-if="showRoleModal" v-model="showRoleModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">ROLE</h3>       
          <strong>{{ role.title }}</strong>
          <p>{{ role.description }}</p> 
          <div>{{role.created_at | moment('LLLL')}}</div>
          <code>{{role.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditRoleModalComponent($event, role)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeleteRoleModalComponent($event, role)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showRoleModal=false" data-action="auto-focus">Cancel</btn>
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
      role: null,
      showCreateRoleModal: false,
      showEditRoleModal: false,
      showDeleteRoleModal: false,
      showRoleModal: false,
      searchTerm: '',
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getRoles().then((response)=>{
        this.on_load = false
      })
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    roles() {
      return this.$store.getters.roles
    },
    filteredRoles: function(){
      if(this.roles.length) {
        return this.roles;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    roleCreated() { 
      this.getRoles() 
    },
    showCreateRoleModalComponent(event) {
      this.showCreateRoleModal = true
    },
    showEditRoleModalComponent(event, role) {
      this.role = role
      this.$nextTick(() => { 
        this.showEditRoleModal = true
      })
    },
    showDeleteRoleModalComponent(event, role) {
      this.role = role
      this.$nextTick(() => { 
        this.showDeleteRoleModal = true
      })
    },
    showRoleModalComponent(event, role) {
      this.role = role
      this.$nextTick(() => { 
        this.showRoleModal = true
      })
    },
    getRoles(event) {
      return this.$store.dispatch('getRoles', { 'search': this.searchTerm })
    }
  },
}
</script>
