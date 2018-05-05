<template>
  <modal 
  v-model="showModal"
  title="Delete Normal"  
  :header="false" 
  :footer="false" 
  :transition-duration="0"
  v-on:hide="$emit('close')"
  >
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
    <template v-if="isbusy">
    <img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" >
    </template>
    <template v-else>
      <div class="form-group">
        <label>Sensor Type</label>
        <pre>{{normal.type.name }}</pre>
      </div>
      <div class="form-group">
        <label>Assigned Patient</label>
        <pre>{{normal.patient.first_name}}</pre>
      </div>
      <div  class="modal-footer text-right" >
        <div class="row">
          <button class="btn btn-success pull-left col-md-4" normal="button" v-on:click="dismiss" data-action="auto-focus">CANCEL</button> 
          <button class="btn btn-danger  pull-right col-md-4" normal="submit">CONFIRM</button>
        </div>
      </div>
    </template>
  </form>
</modal>
</template>
<script>
export default {
  name:'delete-normal-modal',
  props: {
    deleteNormal: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false, 
      normal: (()=>{ return this.deleteNormal })()
    }
  }, 
  methods: { 
    dismiss(){
      this.$toaster.info('deleting was canceled')
      this.showModal = false
    },
    async doAction(event){  
      const axiosOptions = {
        'url': '/normal/normals/'+this.deleteNormal.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.isbusy = true 
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('normal-deleted')
        this.$emit('close')
        this.$emit('deleted')
      }).catch(error => { 
        this.$toaster.error(error.response.data.message) 
      })
      this.isbusy = false
    }
  }
}
</script>