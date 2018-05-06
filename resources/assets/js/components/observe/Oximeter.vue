<template>
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
</template>

<script>
import _ from 'lodash'
import LineChart from './line-chart.js'
import moment from 'moment'

const defaultChartData = () => {
  return {
    labels: ['.'],
    datasets: [{
      backgroundColor: '#000000',
      data: [0],
      label: '...'
    }]
  }
}
const oximeterDataFactory = (d) => {
  d = d || []
  const data = _.reverse(d)
  return { 
    datasets: [
    {
      borderColor: '#3c763d',
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).SpO2)),
      fill: false,
      lineTension: 0,   
      label: 'Oxygen Saturation'
    },
    {
      borderColor: '#1f648b',
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).HR)),
      fill: false,
      lineTension: 0,   
      label: 'Hearth Rate'
    },
    {
      borderColor: '#FF0000',
      borderDash: [5, 5],
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).ST)),
      fill: false, 
      label: 'Sensor Temperature'
    }
    ],
    labels: data.map(payload => moment(payload.created_at).format('lll'))
  }
}
const oximeterDeafultData = () => {
  return {
    oximeterData: defaultChartData(),
    oximeterInterval: null,
    oximeterProviderConfig: {
      isBusy: false
    }
  }
}
export default {
  name: 'Oximeter',
  props: ['selectedPatient', 'selected'],
  components: {
    LineChart
  },
  beforeDestroy: () => {
    clearInterval(this.oximeterInterval)
  },
  data() {
    return { 
      ...oximeterDeafultData(),
      interval: 1000
    }
  },
  watch: {
    oximeterData: {
      handler(state) {
        if(state){
          this.evalNormals(state)
        }
      }
    },
    selected: {
      handler(state) {
        this.oximeterService(Boolean(state))
      },
      deep: true
    }
  },
  computed: {
    oximeterDelay(){
      if(this.selectedPatient){
        if(this.selectedPatient.unit){

          return  parseInt(this.selectedPatient.unit.oximeter_delay)
          
        }

      }

      return 60000
    },
    normal(){
      if(this.selectedPatient){
        if(this.selectedPatient.normal){
          const norm = _.find(this.selectedPatient.normal, n => { return n.type_id === 1})
          if(norm){
            return  norm
          }
        }

      }


      return {upper_limit: 0, lower_limit: 0}
    },
    user() {
      return window._user
    }
  },
  methods: {
    evalNormals(payload){
      const oximeterData = _.find(payload.datasets, o => { return o.label === 'Oxygen Saturation' })

      if(oximeterData){

        oximeterData.data.forEach((v)=>{
         if(v > this.normal.upper_limit){

          this.$notify({
            title: 'Oxygen Saturation',
            content: `high ... ${v}`,
            duration: 15000,
            type: 'warning',
            placement: 'bottom-left'
          })

        }

        if(v < this.normal.lower_limit) {
          this.$notify({
            title: 'Oxygen Saturation',
            content: `low ... ${v}`,
            duration: 15000,
            type: 'danger',
            placement: 'bottom-left'
          })
        }
      })

      }
    },
    oximeterService(state) {
      state = state || false
      if (state) {
        this.oximeterProvider();
        this.oximeterInterval = setInterval(function() {
          this.oximeterProvider();
        }.bind(this), this.oximeterDelay);
      } else {
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
          this.oximeterData = oximeterDataFactory(response.data.data)
          this.oximeterProviderConfig.isBusy = false
        })
        .catch((error) => {
          this.oximeterProviderConfig.isBusy = false
          return Promise.reject(error.response)
        })
      }
    }
  }
}
</script>
