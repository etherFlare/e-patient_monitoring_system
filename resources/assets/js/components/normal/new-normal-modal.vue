<template>
<modal v-model="showModal" v-on:hide="$emit('close')" title="NewNormal" :footer="false">
  <form ref="vForm" v-on:submit.prevent="postNewNormal($event)">
    <template v-if="isBusy">
      <img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" >
    </template>
    <template v-else>
      <div class="form-group" :class="{'has-error': !normal.type_id || hasError('normal.type_id')}">
        <label for="type_id">Type</label>
        <select class="form-control" id="type_id" v-model="normal.type_id" placeholder="...">
          <option disabled selected value> -- select an option -- </option>
          <option v-for="(type, typesOptionIdx) in typesOption" :key="typesOptionIdx" :value="type.value">{{type.label}}</option>
        </select>
        <template v-if="hasError('normal.type_id')">
          <p class="small text-red" v-for="(line, errorIdx) in errors['normal.type_id']" :key="errorIdx">{{line}}</p>
        </template>
      </div>
      <div class="form-group" :class="{'has-error': !normal.patient_id || hasError('normal.patient_id')}">
        <label for="patient_id">Patient</label>
        <select class="form-control" id="patient_id" v-model="normal.patient_id" placeholder="...">
          <option disabled selected value> -- select an option -- </option>
          <option v-for="(patient, patientsOptionIdx) in patientsOption" :key="patientsOptionIdx" :value="patient.value">{{patient.label}}</option>
        </select>
        <template v-if="hasError('normal.patient_id')">
          <p class="small text-red" v-for="(line, errorIdx) in errors['normal.patient_id']" :key="errorIdx">{{line}}</p>
        </template>
      </div>
      <div class="form-group " :class="{'has-error': !normal.upper_limit}">
        <label>Upper Limit</label>
        <input type="text" class="form-control" placeholder="..." v-model="normal.upper_limit"/>
      </div>
      <div class="form-group " :class="{'has-error': !normal.lower_limit}">
        <label>Lower Limit</label>
        <input type="text" class="form-control" placeholder="..." v-model="normal.lower_limit"/>
      </div>
      <div class="modal-footer text-right" >
        <div class="row">
          <button class="btn btn-default pull-left col-md-4" normal="button" v-on:click="showModal=false">CANCEL</button>
          <button class="btn btn-success pull-right col-md-4" :class="{'btn-default': canPost, 'btn-danger': !canPost}" normal="submit">SUBMIT</button>
        </div>
      </div>
    </template>
  </form>
</modal>
</template>
<script>
const blankNormalData = () => {
  return {
    'type_id': null,
    'patient_id': null,
    'upper_limit': '100',
    'lower_limit': '1'
  }
}
export default {
  name: 'new-normal-modal',
  data() {
    return {
      showModal: true,
      isBusy: false,
      normal: blankNormalData(),
      errors: null,
      types: null,
      patients: null
    }
  },
  created() {
    this.getTypes()
    this.getPatients()
  },
  computed: {
    typesOption() {
      if(Boolean(this.types))
      {
        return this.types.data.map(type => { return {label: type.name, value: type.id} } )
      }
      return []
    },
    patientsOption() {
      if(Boolean(this.patients))
      {
        return this.patients.data.map(patient => { return {label: patient.first_name, value: patient.id} } )
      }
      return []
    },
    canPost(){
      let result = true
      Object.entries(this.normal).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    hasError(field) {
      const errors = this.errors
      if(!errors) return false
        return Object.keys(errors).map(key=>key).includes(field)
    },
    async getTypes() {
      const axiosOptions = {
        'url': '/type/types',
        'method': 'get'
      }
      await axios(axiosOptions).then(response => {
        this.types = response.data
      }).catch(error => {
        this.types = null
        return Promise.reject(error.response);
      })
    },
    async getPatients() {
      const axiosOptions = {
        'url': '/patient/patients',
        'method': 'get'
      }
      await axios(axiosOptions).then(response => {
        this.patients = response.data
      }).catch(error => {
        this.patients = null
        return Promise.reject(error.response);
      })
    },
    async postNewNormal(event){
      const axiosOptions = {
        'url': '/normal/normals',
        'method': 'post',
        'data': {normal: this.normal}
      }
      this.errors = null
      this.isBusy = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then( response => {
        this.normal = blankNormalData()
        this.$toaster.success(response.data.msg)
        this.$emit('normal-created')
        this.isBusy = false
        this.showModal = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.$toaster.error(error.response.data.message)
        this.isBusy = false
        return Promise.reject(error.response);
      })
      this.isBusy = false
    }
  }
}
</script>