<template>
  <modal
  v-model="showModal"
  v-on:hide="$emit('close')"
  title="New Patient"
  :footer="false"
  size="lg"
  >
  <form ref="vForm" v-on:submit.prevent="postNewPatient($event)">
    <template v-if="posting">
      <img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" >
    </template>
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
          <button class="btn btn-default pull-left col-md-4" type="button" v-on:click="showModal=false">CANCEL</button>
          <button class="btn btn-success pull-right col-md-4" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">SUBMIT</button>
        </div>
      </div>
    </template>
  </form>
</modal>
</template>
<script>
export default {
  name: 'new-patient-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      patient: {
        title: '',
        description: ''
      },
      selected: [],
      options: [
      {value: 1, label:'Option1'},
      {value: 2, label:'Option2'},
      {value: 3, label:'Option3'},
      {value: 4, label:'Option4'},
      {value: 5, label:'Option5'}
      ]
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
    async postNewPatient(event){
      const axiosOptions = {
        'url': '/patient/patients',
        'method': 'post',
        'data': this.patient
      }
      console.log( this.patient);

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.patient = {title: '', description: ''}
        this.$emit('patient-created')
        setTimeout(() => this.$emit('close'), 500)
        console.log( this.patient);

      }).catch(error => {
        this.$toaster.error(error.response.data.message)
        console.log( error.response.data.messagee);
        this.posting = false
      })
      this.posting = false
    }
  }
}
</script>