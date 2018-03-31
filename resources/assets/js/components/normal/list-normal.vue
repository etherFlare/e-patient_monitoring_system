<template id="normal-list">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateNormalModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Normal</a>
            </div>
          </div>  
          <form v-on:submit.prevent="getNormals($event)">
            <div class="form-inline">
              <div class="form-group">
                <div class="input-group">
                  <input normal="text" class="form-control" v-model="searchTerm"/>
                  <div class="input-group-btn">
                    <button class="btn btn-default" normal="submit">search</button>
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
                  <th>type</th>
                  <th>patient</th>
                  <th class="col-md-2"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(normal, index) in normals" >
                  <td v-on:click="showNormalModalComponent($event, normal)">{{ normal.type_id }}</td>
                  <td v-on:click="showNormalModalComponent($event, normal)">{{ normal.patient_id }}</td>
                  <td class="row"> 
                    <btn size="xs" normal="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showNormalModalComponent($event, normal)"><i class="fa fa-eye"></i> Show</btn>
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
        <!--show modal-->
        <modal ref="showNormalModal" v-if="showNormalModal" v-model="showNormalModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">Reference</h3>       
          <strong>{{ normal.type_id }}</strong>
          <p>{{ normal.patient_id }}</p>
          <p>{{ normal.upper_limit }}</p> 
          <p>{{ normal.lower_limit }}</p> 
          <p>{{ normal.patient_id }}</p>  
          <div>{{normal.created_at | moment('LLLL')}}</div>
          <code>{{normal.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn normal="warning"  class="" v-on:click="showEditNormalModalComponent($event, normal)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn normal="danger"  class="" v-on:click="showDeleteNormalModalComponent($event, normal)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showNormalModal=false" data-action="auto-focus">Cancel</btn>
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
