<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Location" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    >  
    <div slot="default">
      <form v-if="location" ref="vForm" v-on:submit.prevent="updateLocation($event)">
        <template v-if="isbusy"><img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" ></template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !location.name}">
            <label>name</label>
            <input type="text" class="form-control" placeholder="..." v-model="location.name"/>
          </div>
          <div class="form-group" :class="{'has-error': !location.description}">
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="location.description"></textarea>
          </div>
          <div class="modal-footer text-right" >
            <div class="row">
              <button class="btn btn-default pull-left col-md-4" type="button" v-on:click="dismiss=true">CANCEL</button>
              <button class="btn pull-right col-md-4" :class="{'btn-primary': canPost, 'btn-danger': !canPost}" type="submit">UPDATE</button>
            </div>
          </div>
        </template>
      </form>
    </div>
  </modal> 
  <!--verification modal -->
  <modal 
  v-model="dismiss" 
  :transition-duration="0" 
  :header="false"
  >
  <h3>WARNING! DISMISSING UPDATE</h3>
  <div slot="footer">
    <button class="btn btn-success pull-left col-md-4" type="button" v-on:click="dismiss=false" data-action="auto-focus">Back to Update</button> 
    <button class="btn btn-danger pull-right col-md-4" type="button" v-on:click="$emit('close')">Cancel Update</button> 
    
  </div>
</modal> 
<!--verification modal end-->
</section>
</template>
<script>
export default {
  name: 'edit-location-modal',
  props: { 
    editLocation: {
      required: true
    }
  },
  data() {
    return {
      dismiss:false,
      showModal: true,
      isbusy: false,
      location: (()=>{ return Object.assign({}, this.editLocation) })()
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.location).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async updateLocation(event){
      const axiosOptions = {
        'url': '/location/locations/'+this.editLocation.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.location
      }
      this.isbusy = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('location-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.isbusy = false
      this.showModal = false
    }
  }
}
</script>name