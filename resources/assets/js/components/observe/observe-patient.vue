<template>
  <div class="row">
    <div class="col-md-4">
      <div class="box box-solid ">
        <div class="box-header">
          <i class="fa fa-circle"></i>
          <h3 class="box-title">Patients</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" v-on:click="showPatientsModal=true"><i class="fa fa-search"></i></button>
            <modal v-model="showPatientsModal"
            title="Patients"
            v-on:hide="showPatientsModal=false"
            ref="patientsModal"
            :footer="false"
            :keyboard="true"
            :backdrop="true"
            size="lg"
            append-to-body>
            <patients-select :patients="patients" v-on:add-patient="addPatient" v-on:remove-patient="removePatient"></patients-select>
          </modal>
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" v-on:click="patientsProvider()"><i class="fa fa-refresh"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped no-margin">
          <thead>
            <tr>
              <th>Name</th>
              <th>Location</th>
              <th>...</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(patient, patientIdx) in patients" :key="patientIdx">
              <td>{{patient.first_name}}</td>
              <td>{{patient.location.name}}</td>
              <td class="text-right">
                <button type="button" class="btn btn-primary btn-sm" v-on:click="showPatientObservationConfig(patient)"><i class="fa fa-fw fa-wrench"></i></button> 
                <button type="button" class="btn btn-danger btn-sm" v-on:click="removePatient(patient.id)"><i class="fa fa-fw fa-times"></i></button>

                <button type="button" class="btn btn-sm" 
    :class="{'btn-default':  patient.id !== selected, 'btn-primary': patient.id === selected}"

                v-on:click="()=>{ selected = (patient.id === selected)?null:patient.id;  }"><i 
 :class="{'fa-square-o':  patient.id !== selected, 'fa-check-square-o': patient.id === selected}"
 class="fa fa-fw"></i></button>

 
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="overlay" v-if="patientsProviderIsBusy">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Oximeter</h3>
            <div class="box-tools pull-right">
              <i class="fa fa-spin fa-refresh" v-if="oximeterProviderConfig.isBusy"></i>
              <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
            </div>
          </div>
          <div class="box-body">
            <line-chart :chart-data="oximeterData" :options="{responsive: true, maintainAspectRatio: false}"></line-chart>
          </div>
          <div class="overlay" v-if="!selected">
            <i class="fa" :class="{'fa-refresh fa-spin': selected, 'fa-info': !selected}"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Sphygmomanometer</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
            </div>
          </div>
          <div class="box-body">
            <line-chart :chart-data="oximeterData"></line-chart>
          </div>
          <div class="overlay">
            <i class="fa" :class="{'fa-refresh fa-spin': selected, 'fa-info': !selected}"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Thermometer</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
            </div>
          </div>
          <div class="box-body">
            <line-chart :chart-data="oximeterData"></line-chart>
          </div>
          <div class="overlay">
            <i class="fa" :class="{'fa-refresh fa-spin': selected, 'fa-info': !selected}"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <modal v-model="showPatientObservationConfigModal"
  title="Patient"
  v-on:hide="showPatientObservationConfigModal=false"
  ref="patientObservationConfig"
  :footer="false"
  :keyboard="true"
  :backdrop="true"
  size="lg"
  append-to-body>
  <pre>{{patientObservationConfig}}</pre>
</modal>
</div>
</template>
<script>
import PatientsSelect from './patients.vue'
import LineChart from './line-chart.js'
import moment from 'moment'
import _ from 'lodash'
const defaultChartData = ()=>{
  return {
    labels: ['.'],
    datasets: [{ label: '...', backgroundColor: '#000000', data: [0] } ]
  }
}
const oximeterDataFactory = (d)=>{
  d = d || []
  const data = _.reverse(d)
  return {
    labels: data.map(di => moment(di.created_at).format('lll') ),
    datasets: [
    { 
      label: 'Oxygen Saturation', 
      backgroundColor: '#3c763d', 
      data: data.map(di => JSON.parse(di.sensor_value).SpO2 )
    }
    ]
  }  
} 
const defaultPatientsPayload = () => {
  return {
    "current_page": 1,
    "data": [],
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 0,
    "total": 0
  }
}
export default {
  name: 'observe-patient',
  components: { PatientsSelect, LineChart },
  created() {
    this.patientsProvider() 
  },
  mounted() {
    this.patientsProvider()  
  },
  beforeDestroy: function(){
    clearInterval(this.oximeterInterval);
  },
  data() {
    return {
      showPatientObservationConfigModal: false,
      patientObservationConfig: null,
      showPatientsModal: false,
      patientsPayload: defaultPatientsPayload(),
      patientsProviderIsBusy: false,
      selected: null,
      oximeterInterval:  null,
      oximeterData: defaultChartData(),
      oximeterProviderConfig: {
        isBusy: false
      }
    }
  }, 
  watch: {
    selected: {
      handler(state){
        this.oximeterService( Boolean(state) )
      },
      deep: true
    }
  },
  computed: {
    patients() {
      return this.patientsPayload.data
    },
    selectedPatient() {
      const patients = this.patients
      return _.find(patients, o=>o.id === this.selected )
    },
    user() {
      return window._user
    }
  },
  methods: {
    oximeterService(state) {
      state = state || false
      if(state){
        this.oximeterProvider();
        this.oximeterInterval = setInterval(function () {
          this.oximeterProvider();
        }.bind(this), 5000 ); 
      }else{
        clearInterval(this.oximeterInterval);
        this.oximeterData = defaultChartData()
      }
    },
    oximeterProvider() { 
      if(this.selectedPatient){ 
        const axiosOptions = {
          'url': `/metadata/metadatas`,
          'method': 'get',
          'params': {
            type: 2, 
            per_page: 5, 
            unit_id: this.selectedPatient.unit.id 
          }
        }
        this.oximeterProviderConfig.isBusy = true
        axios(axiosOptions)
        .then((response) => {  
          const oxi = oximeterDataFactory(response.data.data) 
          console.log('oximeterProvider', oxi)
          this.oximeterData = oxi
          this.oximeterProviderConfig.isBusy = false
        })
        .catch((error) => {
          this.oximeterProviderConfig.isBusy = false
          return Promise.reject(error.response)
        })
      }
    },
    showPatientObservationConfig(patient) {
      this.patientObservationConfig = patient
      this.showPatientObservationConfigModal = true
    },
    removePatient(patient_id) { 
      const axiosOptions = {
        'url': `/patient/${patient_id}/user/${this.user.id}`,
        'method': 'delete'
      }
      axios(axiosOptions)
      .then((response) => {
        this.patientsPayload = response.data
        this.$notify({
          content: '... patient removed'
        })
        this.patientsProvider()
        return response
      })
      .catch((error) => {
        return Promise.reject(error.response)
      }) 
    },
    addPatient(patient_id){
      const axiosOptions = {
        'url': `/patient/${patient_id}/user`,
        'method': 'post',
        'data': {user_id: this.user.id}
      }
      axios(axiosOptions)
      .then((response) => {
        this.patientsPayload = response.data
        this.$notify({
          content: '... user can now observe [patient]!'
        })
        this.patientsProvider()
        return response
      })
      .catch((error) => {
        return Promise.reject(error.response)
      })
    },
    patientsProvider(params) {
      this.patientsProviderIsBusy = true
      params = params || {}
      let payload = Object.assign({}, this.patientsPayload, {data: []})
      params = Object.assign({}, payload, params)
      this.patientsPayload = defaultPatientsPayload()
      const axiosOptions = {
        'url': `/user/${this.user.id}/patient`,
        'method': 'get',
        'params': params
      }
      axios(axiosOptions)
      .then((response) => {
        this.patientsPayload = response.data
        this.patientsProviderIsBusy = false
        return response
      })
      .catch((error) => {
        this.patientsProviderIsBusy = false
        return Promise.reject(error.response)
      })
    }
  }
}
</script>
