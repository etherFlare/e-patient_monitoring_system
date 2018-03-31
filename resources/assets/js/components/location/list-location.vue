<template id="location-list">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateLocationModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Location</a>
            </div>
          </div>  
          <form v-on:submit.prevent="getLocations($event)">
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
                <tr v-for="(location, index) in locations" >
                  <td v-on:click="showLocationModalComponent($event, location)">{{ location.name }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showLocationModalComponent($event, location)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!locations.length">
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
        <new-location-modal ref="showCreateLocationModal" v-if="showCreateLocationModal" v-on:close="showCreateLocationModal = false" v-on:location-created="locationCreated" ></new-location-modal>
        <edit-location-modal v-if="showEditLocationModal" v-on:close="showEditLocationModal = false" :edit-location="location" v-on:location-updated="getLocations"></edit-location-modal> 
        <delete-location-modal ref="showDeleteLocationModal" :delete-location="location" v-if="showDeleteLocationModal" v-on:location-deleted="getLocations" v-on:close="showDeleteLocationModal = false"  v-on:deleted="showLocationModal = false" ></delete-location-modal>

        <!--show modal-->
        <modal ref="showLocationModal" v-if="showLocationModal" v-model="showLocationModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">LOCATION</h3>       
          <strong>{{ location.name }}</strong>
          <p>{{ location.description }}</p> 
          <div>{{location.created_at | moment('LLLL')}}</div>
          <code>{{location.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditLocationModalComponent($event, location)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeleteLocationModalComponent($event, location)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showLocationModal=false" data-action="auto-focus">Cancel</btn>
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
      location: null,
      showCreateLocationModal: false,
      showEditLocationModal: false,
      showDeleteLocationModal: false,
      showLocationModal: false,
      searchTerm: '',
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getLocations().then((response)=>{
        this.on_load = false
      })
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    locations() {
      return this.$store.getters.locations
    },
    filteredLocations: function(){
      if(this.locations.length) {
        return this.locations;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    locationCreated() { 
      this.getLocations() 
    },
    showCreateLocationModalComponent(event) {
      this.showCreateLocationModal = true
    },
    showEditLocationModalComponent(event, location) {
      this.location = location
      this.$nextTick(() => { 
        this.showEditLocationModal = true
      })
    },
    showDeleteLocationModalComponent(event, location) {
      this.location = location
      this.$nextTick(() => { 
        this.showDeleteLocationModal = true
      })
    },
    showLocationModalComponent(event, location) {
      this.location = location
      this.$nextTick(() => { 
        this.showLocationModal = true
      })
    },
    getLocations(event) {
      return this.$store.dispatch('getLocations', { 'search': this.searchTerm })
    }
  },
}
</script>
