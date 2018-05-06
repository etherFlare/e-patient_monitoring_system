<template>
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Thermometer</h3>
      <div class="box-tools pull-right">
        <i class="fa fa-spin fa-refresh" v-if="thermometerProviderConfig.isBusy"></i>
        <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
      </div>
    </div>
    <div class="box-body">
      <line-chart :chart-data="thermometerData" :options="{responsive: true, maintainAspectRatio: false}"></line-chart>
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
const thermometerDataFactory = (d) => {
  d = d || []
  const data = _.reverse(d)
  return { 
    datasets: [ 
    {
      borderColor: '#FF0000',
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).HT)),
      fill: false, 
      lineTension: 0,   
      label: 'Human Temperature'
    }
    ],
    labels: data.map(payload => moment(payload.created_at).format('lll'))
  }
}
const thermometerDeafultData = () => {
  return {
    thermometerData: defaultChartData(),
    thermometerInterval: null,
    thermometerProviderConfig: {
      isBusy: false
    }
  }
}
export default {
  name: 'Thermometer',
  props: ['selectedPatient', 'selected'],
  components: {
    LineChart
  },
  beforeDestroy: () => {
    clearInterval(this.thermometerInterval)
  },
  data() {
    return { 
      ...thermometerDeafultData(),
      interval: 60000
    }
  },
  watch: {

     thermometerData: {
      handler(state) {
        if(state){
          this.evalNormals(state)
       }
      }
    },
    selected: {
      handler(state) {
        this.thermometerService(Boolean(state))
      },
      deep: true
    }
  },
  computed: {
     thermometerDelay(){
      if(this.selectedPatient){
        if(this.selectedPatient.unit){

          return  parseInt(this.selectedPatient.unit.thermometer_delay)
         
        }

      }

      return 60000
    },
    normal(){
      if(this.selectedPatient){
        if(this.selectedPatient.normal){
          const norm = _.find(this.selectedPatient.normal, n => { return n.type_id === 3})
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
      const thermometerData = _.find(payload.datasets, o => { return o.label === 'Human Temperature' })

     if(thermometerData){
       thermometerData.data.forEach((v)=>{
        if(v > this.normal.upper_limit){
             this.$notify({
            title: 'Human Temperatur',
            content: `high ... ${v}`,
           duration: 30000,
            type: 'warning',
           placement: 'bottom-left'
          })

        }

        if(v < this.normal.lower_limit) {
          this.$notify({
            title: 'Human Temperatur',
            content: `low ... ${v}`,
            duration: 30000,
            type: 'danger',
            placement: 'bottom-left'
          })
        }
      })

     }
    },
    thermometerService(state) {
      state = state || false
      if (state) {
        this.thermometerProvider();
        this.thermometerInterval = setInterval(function() {
          this.thermometerProvider();
        }.bind(this), this.thermometerDelay);
      } else {
        clearInterval(this.thermometerInterval);
        this.thermometerData = defaultChartData()
      }
    },
    thermometerProvider() {
      if(this.selectedPatient){
        const axiosOptions = {
          'url': `/metadata/metadatas`,
          'method': 'get',
          'params': {
            type: 3,
            per_page: 5,
            unit_id: this.selectedPatient.unit.id
          }
        }
        this.thermometerProviderConfig.isBusy = true
        axios(axiosOptions)
        .then((response) => {
          this.thermometerData = thermometerDataFactory(response.data.data)
          this.thermometerProviderConfig.isBusy = false
        })
        .catch((error) => {
          this.thermometerProviderConfig.isBusy = false
          return Promise.reject(error.response)
        })
      }
    }
  }
}
</script>
