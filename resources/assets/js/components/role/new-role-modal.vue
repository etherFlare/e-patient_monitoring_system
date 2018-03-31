<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Role"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewRole($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !role.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="role.title"/>
          </div>
          <div class="form-group" >
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="role.description"></textarea>
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
  name: 'new-role-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      role: {
        title: '',
        description: ''
      }
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.role).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewRole(event){
      const axiosOptions = {
        'url': '/role/roles',
        'method': 'post',
        'data': this.role
      }
 console.log( this.role); 

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.role = {title: '', description: ''}
        this.$emit('role-created')
        setTimeout(() => this.$emit('close'), 500)
console.log( this.role); 

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