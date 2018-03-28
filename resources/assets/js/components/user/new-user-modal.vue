<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New User"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewUser($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !user.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="user.title"/>
          </div>
          <div class="form-group" :class="{'has-error': !user.description}">
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="user.description"></textarea>
          </div>
          <div class="modal-footer text-right" >
            <div class="row">
              <button class="btn btn-default pull-left col-md-4" type="button" v-on:click="showModal=false">CANCEL</button>
               <button class="btn btn-success pull-right col-md-4" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">SUBMIT</button>
            </div>
          </div>
        </template>
      </form>
  </modal>
</template>
<script>
export default {
  name: 'new-user-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      user: {
        title: '',
        description: ''
      }
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.user).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewUser(event){
      const axiosOptions = {
        'url': '/user/users',
        'method': 'post',
        'data': this.user
      }
 console.log( this.user); 

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.user = {title: '', description: ''}
        this.$emit('user-created')
        setTimeout(() => this.$emit('close'), 500)
console.log( this.user); 

      }).catch(error => {
        this.$toaster.error(error.response.data.message)
         console.log( error.response.data.messagee);
         this.posting = false
      })
      this.posting = false
    }
  }
}
</script>