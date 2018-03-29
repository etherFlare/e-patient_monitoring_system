<template>
  <modal 
  v-model="showModal"
  title="Delete User"  
  :header="false" 
  :footer="false" 
  :transition-duration="0"
  v-on:hide="$emit('close')"
  >
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
    <template v-if="posting">...deleting</template>
    <template v-else>
      <div slot="title" >
        <div class="box-profile ">
          <p>your about to delete</p>
              <img class="animated-box profile-user-img img-responsive img-circle" src="/img/heart-beat.png" alt="User profile picture" >
              <h3 class="profile-username text-center"> {{ user.last_name }}, {{ user.first_name }} {{ user.middle_name }}</h3>
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
  name:'delete-user-modal',
  props: {
    deleteUser: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      posting: false, 
      user: (()=>{ return this.deleteUser })()
    }
  }, 
  methods: { 
    dismiss(){
      this.$toaster.info('deleting was canceled')
      this.showModal = false
    },
    async doAction(event){  
      const axiosOptions = {
        'url': '/user/users/'+this.deleteUser.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.posting = true 
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('user-deleted')
        this.$emit('close')
        this.$emit('deleted')
      }).catch(error => { 
        this.$toaster.error(error.response.data.message) 
      })
      this.posting = false
    }
  }
}
</script>