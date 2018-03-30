<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Patient" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    size="lg"
    >  
    <div slot="default">
      <form v-if="patient" ref="vForm" v-on:submit.prevent="updatePatient($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="row">
        <div class="col-md-6">
          <div class="form-group col-md-4" :class="{'has-error': !patient.first_name}">
            <label>First Name</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.first_name"/>
          </div>
          <div class="form-group col-md-4" :class="{'has-error': !patient.middle_name}">
            <label>Middle Name</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.middle_name"/>
          </div>
          <div class="form-group col-md-4" :class="{'has-error': !patient.last_name}">
            <label>Surname</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.last_name"/>
          </div>
          <div class="form-group " :class="{'has-error': !patient.contact_number}">
            <label>Phone Number</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.contact_number"/>
          </div>
          <div class="form-group " :class="{'has-error': !patient.home_address}">
            <label>Home Address</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.home_address"/>
          </div>
          <div class="form-group " :class="{'has-error': !patient.contact_person}">
            <label>Contact Person</label>
            <input type="text" class="form-control" placeholder="..." v-model="patient.contact_person"/>
          </div>
          <div class="form-group " :class="{'has-error': !patient.gender}">
            <label >gender</label>
            <div class="radio">
              <label class="radio-inline"><input type="radio" name="optradio">Option 1</label>
              <label class="radio-inline"><input type="radio" name="optradio">Option 2</label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="role">Location</label>
            <select class="form-control" id="location">
              <option disabled selected value> -- select an option -- </option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>

          <div class="form-group">
            <label for="role">Unit</label>
            <select class="form-control" id="unit">
              <option disabled selected value> -- select an option -- </option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
          <div class="form-group" :class="{'has-error': !patient.comment}">
            <label>Comment</label>
            <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="patient.comment"></textarea>
          </div>
        </div>
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
  name: 'edit-patient-modal',
  props: { 
    editPatient: {
      required: true
    }
  },
  data() {
    return {
      dismiss:false,
      showModal: true,
      posting: false,
      patient: (()=>{ return Object.assign({}, this.editPatient) })()
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.patient).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async updatePatient(event){
      const axiosOptions = {
        'url': '/patient/patients/'+this.editPatient.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.patient
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('patient-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
      this.showModal = false
    }
  }
}
</script>