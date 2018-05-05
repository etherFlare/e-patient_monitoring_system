<template>
  <modal 
  v-model="showModal"
  title="Delete Type"  
  :header="false" 
  :footer="false" 
  :transition-duration="0"
  v-on:hide="$emit('close')"
  >
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
    <template v-if="isbusy"><img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" ></template>
    <template v-else>
      <div class="form-group">
        <label>name</label>
        <pre>{{type.name}}</pre>
      </div>
      <div class="form-group">
        <label>body</label>
        <pre>{{type.description}}</pre>
      </div>
      <div  class="modal-footer text-right" >
        <div class="row">
          <button class="btn btn-success pull-left col-md-4" type="button" v-on:click="dismiss" data-action="auto-focus">CANCEL</button> 
          <button class="btn btn-danger  pull-right col-md-4" type="submit">CONFIRM</button>
        </div>
      </div>
    </template>
  </form>
</modal>
</template>
<script>
export default {
  name:'delete-type-modal',
  props: {
    deleteType: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false, 
      type: (()=>{ return this.deleteType })()
    }
  }, 
  methods: { 
    dismiss(){
      this.$toaster.info('deleting was canceled')
      this.showModal = false
    },
    async doAction(event){  
      const axiosOptions = {
        'url': '/type/types/'+this.deleteType.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.isbusy = true 
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('type-deleted')
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