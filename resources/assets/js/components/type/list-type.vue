<template id="type-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateTypeModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Type</a>
            </div>
          </div>  
          <form v-on:submit.prevent="getTypes($event)">
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
                  <th>name</th>
                  <th class="col-md-2"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(type, index) in types" >
                  <td v-on:click="showTypeModalComponent($event, type)">{{ type.name }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showTypeModalComponent($event, type)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!types.length">
                  <td colspan="2" class="text-center">
                    <p> {{searchTerm}} was not in the list</p>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-type-modal ref="showCreateTypeModal" v-if="showCreateTypeModal" v-on:close="showCreateTypeModal = false" v-on:type-created="typeCreated" ></new-type-modal>
        <edit-type-modal v-if="showEditTypeModal" v-on:close="showEditTypeModal = false" :edit-type="type" v-on:type-updated="getTypes"></edit-type-modal> 
        <delete-type-modal ref="showDeleteTypeModal" :delete-type="type" v-if="showDeleteTypeModal" v-on:type-deleted="getTypes" v-on:close="showDeleteTypeModal = false"  v-on:deleted="showTypeModal = false" ></delete-type-modal>

        <!--show modal-->
        <modal ref="showTypeModal" v-if="showTypeModal" v-model="showTypeModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">TYPE</h3>       
          <strong>{{ type.name }}</strong>
          <p>{{ type.description }}</p> 
          <div>{{type.created_at | moment('LLLL')}}</div>
          <code>{{type.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditTypeModalComponent($event, type)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeleteTypeModalComponent($event, type)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showTypeModal=false" data-action="auto-focus">Cancel</btn>
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
      type: null,
      showCreateTypeModal: false,
      showEditTypeModal: false,
      showDeleteTypeModal: false,
      showTypeModal: false,
      searchTerm: '',
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getTypes().then((response)=>{
        this.on_load = false
      })
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    types() {
      return this.$store.getters.types
    },
    filteredTypes: function(){
      if(this.types.length) {
        return this.types;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    typeCreated() { 
      this.getTypes() 
    },
    showCreateTypeModalComponent(event) {
      this.showCreateTypeModal = true
    },
    showEditTypeModalComponent(event, type) {
      this.type = type
      this.$nextTick(() => { 
        this.showEditTypeModal = true
      })
    },
    showDeleteTypeModalComponent(event, type) {
      this.type = type
      this.$nextTick(() => { 
        this.showDeleteTypeModal = true
      })
    },
    showTypeModalComponent(event, type) {
      this.type = type
      this.$nextTick(() => { 
        this.showTypeModal = true
      })
    },
    getTypes(event) {
      return this.$store.dispatch('getTypes', { 'search': this.searchTerm })
    }
  },
}
</script>
