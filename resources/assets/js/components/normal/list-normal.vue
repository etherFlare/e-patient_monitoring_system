<template id="normal-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
               <a href="print/normal" v-if="userIsAdmin"  target="_blank" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-print"></span> <span>PRINT</span></a>
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateNormalModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Normal</a>
            </div>
          </div>
          <form v-on:submit.prevent="getNormals($event)">
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
              <thead>
                <tr>
                  <th>type</th>
                  <th>patient</th>
                  <th class="col-md-2"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(normal, index) in normals" >
                  <td v-on:click="showNormalModalComponent($event, normal)">{{ normal.type.name }}</td>
                  <td v-on:click="showNormalModalComponent($event, normal)">{{ normal.patient.first_name}}</td>
                  <td class="row">
                    <btn size="xs" type="primary" class="col-xs-12" v-on:click="showNormalModalComponent($event, normal)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!normals.length">
                  <td colspan="3" class="text-center">
                    <p> {{searchTerm}} was not in the list</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-normal-modal ref="showCreateNormalModal" v-if="showCreateNormalModal" v-on:close="showCreateNormalModal = false" v-on:normal-created="normalCreated" ></new-normal-modal>
        <edit-normal-modal v-if="showEditNormalModal" v-on:close="showEditNormalModal = false" :edit-normal="normal" v-on:normal-updated="getNormals"></edit-normal-modal>
        <delete-normal-modal ref="showDeleteNormalModal" :delete-normal="normal" v-if="showDeleteNormalModal" v-on:normal-deleted="getNormals" v-on:close="showDeleteNormalModal = false"  v-on:deleted="showNormalModal = false" ></delete-normal-modal>
        <modal ref="showNormalModal" v-if="showNormalModal" v-model="showNormalModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">Reference</h3>
          <div class="row">
            <div class="col-md-6">
              <strong>Sensor Type</strong>
              <p>{{ normal.type.name }}</p>
              <hr/>
              <strong>Assigned Patient</strong>
              <p>{{ normal.patient.first_name }}</p>
              <hr/>
            </div>
            <div class="col-md-6">
              <strong>Upper Limit</strong>
              <p>
                <code>{{ normal.upper_limit }}</code>
              </p>
              <hr/>
              <strong>Lower Limit</strong>
              <p>
                <code>{{ normal.lower_limit }}</code>
              </p>
              <hr/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <strong>Date Created</strong>
              <div>{{normal.created_at | moment('LLLL')}}</div>
              <code>{{normal.created_at | moment('from')}}</code>
            </div>
            <div class="col-md-6">
              <strong>Date Updated</strong>
              <div>{{normal.updated_at | moment('LLLL')}}</div>
              <code>{{normal.updated_at | moment('from')}}</code>
            </div>
          </div>
          <div slot="footer">
            <btn type="warning"  v-if="userCaneEdit" v-on:click="showEditNormalModalComponent($event, normal)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
            <btn type="danger"  v-if="userCanDelete"v-on:click="showDeleteNormalModalComponent($event, normal)"><i class="fa fa-trash-o"  aria-hidden="true"></i> Delete</btn>
            <btn  v-on:click="showNormalModal=false" data-action="auto-focus">Cancel</btn>
          </div>
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
      normal: null,
      showCreateNormalModal: false,
      showEditNormalModal: false,
      showDeleteNormalModal: false,
      showNormalModal: false,
      searchTerm: '',
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getNormals().then((response)=>{
        this.on_load = false
      })
    })
  },
  computed: {
      userCanEdit(){
      const roles = this.$store.getters.user.roles
      const editRole = _.find(roles, function(role) { return role.label === 'editor'; });
      if(editRole){
        return editRole
      }
      return false
    },
    userCanDelete(){
      const roles = this.$store.getters.user.roles
      const deleteRole = _.find(roles, function(role) { return role.label === 'cleaner'; });
      if(deleteRole){
        return deleteRole
      }
      return false
    },
     userIsAdmin(){
      const roles = this.$store.getters.user.roles
      const adminRole = _.find(roles, function(role) { return role.label === 'administrator'; });
      if(adminRole){
        return adminRole
      }
      return false
    },
    loading() {
      return this.$store.getters.loading
    },
    normals() {
      return this.$store.getters.normals
    },
    filteredNormals: function(){
      if(this.normals.length) {
        return this.normals;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    normalCreated() {
      this.getNormals()
    },
    showCreateNormalModalComponent(event) {
      this.showCreateNormalModal = true
    },
    showEditNormalModalComponent(event, normal) {
      this.normal = normal
      this.$nextTick(() => {
        this.showEditNormalModal = true
      })
    },
    showDeleteNormalModalComponent(event, normal) {
      this.normal = normal
      this.$nextTick(() => {
        this.showDeleteNormalModal = true
      })
    },
    showNormalModalComponent(event, normal) {
      this.normal = normal
      this.$nextTick(() => {
        this.showNormalModal = true
      })
    },
    getNormals(event) {
      return this.$store.dispatch('getNormals', { 'search': this.searchTerm })
    }
  },
}
</script>
