<template>
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Sphygmomanometer</h3>
      <div class="box-tools pull-right">
        <i class="fa fa-spin fa-refresh" v-if="sphygmomanometerProviderConfig.isBusy"></i>
        <button type="button" class="btn btn-box-tool"><i class="fa fa-wrench"></i></button>
      </div>
    </div>
    <div class="box-body">
      <line-chart :chart-data="sphygmomanometerData" :options="{responsive: true, maintainAspectRatio: false}"></line-chart>
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
const sphygmomanometerDataFactory = (d) => {
  d = d || []
  const data = _.reverse(d)
  return { 
    datasets: [
    {
      borderColor: '#3c763d',
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).systole)),
      fill: false,
      lineTension: 0,   
      label: 'Systole'
    },
    {
      borderColor: '#1f648b',
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).diastole)),
      fill: false,
      lineTension: 0,   
      label: 'Diastole'
    },
    {
      borderColor: '#FF0000',
      borderDash: [5, 5],
      data: data.map(payload => parseFloat(JSON.parse(payload.sensor_value).pulserate)),
      fill: false, 
      lineTension: 0,   
      label: 'Pulse Rate'
    }
    ],
    labels: data.map(payload => moment(payload.created_at).format('lll'))
  }
}
const sphygmomanometerDeafultData = () => {
  return {
    sphygmomanometerData: defaultChartData(),
    sphygmomanometerInterval: null,
    sphygmomanometerProviderConfig: {
      isBusy: false
    }
  }
}
export default {
  name: 'Sphygmomanometer',
  props: ['selectedPatient', 'selected'],
  components: {
    LineChart
  },
  beforeDestroy: () => {
    clearInterval(this.sphygmomanometerInterval)
  },
  data() {
    return { 
      ...sphygmomanometerDeafultData(),
      interval: 5000
    }
  },
  watch: {
    selected: {
      handler(state) {
        this.sphygmomanometerService(Boolean(state))
      },
      deep: true
    }
  },
  computed: {
    user() {
      return window._user
    }
  },
  methods: {
    sphygmomanometerService(state) {
      state = state || false
      if (state) {
        this.sphygmomanometerProvider();
        this.sphygmomanometerInterval = setInterval(function() {
          this.sphygmomanometerProvider();
        }.bind(this), this.interval);
      } else {
        clearInterval(this.sphygmomanometerInterval);
        this.sphygmomanometerData = defaultChartData()
      }
    },
    sphygmomanometerProvider() {
      if(this.selectedPatient){
        const axiosOptions = {
          'url': `/metadata/metadatas`,
          'method': 'get',
          'params': {
            type: 1,
            per_page: 5,
            unit_id: this.selectedPatient.unit.id
          }
        }
        this.sphygmomanometerProviderConfig.isBusy = true
        axios(axiosOptions)
        .then((response) => {
          this.sphygmomanometerData = sphygmomanometerDataFactory(response.data.data)
          this.sphygmomanometerProviderConfig.isBusy = false
        })
        .catch((error) => {
          this.sphygmomanometerProviderConfig.isBusy = false
          return Promise.reject(error.response)
        })
      }
    }
  }
}
</script>
