<template>
  <modal 
  v-model="showModal"
  title="Delete Role"  
  :header="false" 
  :footer="false" 
  :transition-duration="0"
  v-on:hide="$emit('close')"
  >
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
    <template v-if="isbusy">
        <img class="animated-box img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
      </template>
    <template v-else>
      <div class="form-group">
        <label>title</label>
        <pre>{{role.title}}</pre>
      </div>
      <div class="form-group">
        <label>description</label>
        <pre>{{role.description}}</pre>
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
  name:'delete-role-modal',
  props: {
    deleteRole: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false, 
      role: (()=>{ return this.deleteRole })()
    }
  }, 
  methods: { 
    dismiss(){
      this.$toaster.info('deleting was canceled')
      this.showModal = false
    },
    async doAction(event){  
      const axiosOptions = {
        'url': '/role/roles/'+this.deleteRole.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.isbusy = true 
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('role-deleted')
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