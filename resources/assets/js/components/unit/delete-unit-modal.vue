<template>
  <modal v-model="showModal" title="DeleteUnit" :header="false" :footer="false" :transition-duration="0" v-on:hide="$emit('close')">
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
     <template v-if="isbusy">
            <img class="animated-box  img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
          </template>
    <template v-else>
      <div slot="title" >
        <div class="box-profile ">
          <code>your about to delete</code>
              <img class="animated-box profile-user-img img-responsive img-circle" src="/img/heart-beat.png" alt="Unit profile picture" >
              <h3 class="profile-username text-center"> {{ unit.label }}</h3>
              <p class="text-center">{{ unit.mac_address }}</p>
            </div>
      </div>
       <h2 class="text-center">!! ARE YOU SURE !!</h2>
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
  name:'delete-unit-modal',
  props: {
    deleteUnit: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false, 
      unit: (()=>{ return this.deleteUnit })()
    }
  }, 
  methods: { 
    dismiss(){
      this.$toaster.info('deleting was canceled')
      this.showModal = false
    },
    async doAction(event){  
      const axiosOptions = {
        'url': '/unit/units/'+this.deleteUnit.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.isbusy = true 
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('unit-deleted')
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