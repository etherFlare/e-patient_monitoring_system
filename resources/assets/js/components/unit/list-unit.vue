<template id="unit-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateUnitModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Unit</a>
            </div>
          </div>
          <form v-on:submit.prevent="getUnits($event)">
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
                  <th>mac_address</th>
                  <th>is active</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(unit, index) in units">
                  <td>{{ index + 1 }}</td>
                  <td>{{ unit.mac_address }}</td>
                  <td>{{ unit.unit_is_active }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-3" style="margin-left:3px;margin-right:3px;" v-on:click="showUnitModalComponent($event, unit)"><i class="fa fa-eye"></i> Show</btn>
                    <btn size="xs" type="warning"  class="col-xs-3"style="margin-left:3px;margin-right:3px;" v-on:click="showEditUnitModalComponent($event, unit)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
                    <btn size="xs" type="danger"  class="col-xs-3" style="margin-left:3px;margin-right:3px;"  v-on:click="showDeleteUnitModalComponent($event, unit)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-unit-modal ref="showCreateUnitModal" v-if="showCreateUnitModal" v-on:close="showCreateUnitModal = false" v-on:unit-created="unitCreated" ></new-unit-modal>
        <edit-unit-modal v-if="showEditUnitModal" v-on:close="showEditUnitModal = false" :edit-unit="unit" v-on:unit-updated="getUnits"></edit-unit-modal> 
        <delete-unit-modal ref="showDeleteUnitModal" :delete-unit="unit" v-if="showDeleteUnitModal" v-on:unit-deleted="getUnits" v-on:close="showDeleteUnitModal = false"></delete-unit-modal>

        <!--show modal-->
        <modal ref="showUnitModal" v-if="showUnitModal" v-model="showUnitModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">UNIT</h3>       
          <strong>{{ unit.mac_address }}</strong><hr/>
          <strong>{{ unit.unit_is_active }}</strong><hr/>
          <strong>{{ unit.oximeter_is_active }}</strong><hr/>
          <strong>{{ unit.bp_is_active }}</strong><hr/>
          <strong>{{ unit.thermometer_is_active }}</strong><hr/>
          <strong>{{ unit.oximeter_delay }}</strong><hr/>
          <strong>{{ unit.bp_delay }}</strong><hr/>
          <strong>{{ unit.thermometer_delay }}</strong><hr/>
          <code>{{unit.created_at | moment('from')}}</code><hr/>
           <code>{{unit.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditUnitModalComponent($event, unit)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeleteUnitModalComponent($event, unit)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showUnitModal=false" data-action="auto-focus">Cancel</btn>
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
      unit: null,
      showCreateUnitModal: false,
      showEditUnitModal: false,
      showDeleteUnitModal: false,
      showUnitModal: false,
      searchTerm: '',
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getUnits().then((response)=>{
        this.on_load = false
      })
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    units() {
      return this.$store.getters.units
    },
    filteredUnits: function(){
      if(this.units.length) {
        return this.units;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    unitCreated() { 
      this.getUnits() 
    },
    showCreateUnitModalComponent(event) {
      this.showCreateUnitModal = true
    },
    showEditUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showEditUnitModal = true
      })
    },
    showDeleteUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showDeleteUnitModal = true
      })
    },
    showUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showUnitModal = true
      })
    },
    getUnits(event) {
      return this.$store.dispatch('getUnits', { 'search': this.searchTerm })
    }
  },
}
</script>
