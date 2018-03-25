<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Post"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewUser($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <!--
          <div class="form-group" :class="{'has-error': !post.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="post.title"/>
          </div>
          <div class="form-group" :class="{'has-error': !post.body}">
            <label>body</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="post.body"></textarea>
          </div>
          -->
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
         name:'', 
        email:'', 
        password:'',
        confirm_password:'',
        first_name:'',
        middle_name:'',
        last_name:'',
        contact_number:'',
        is_archive:'',
        comment:''
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
      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.user = {title: '', body: ''}
        this.$emit('user-created')
        setTimeout(() => this.$emit('close'), 500)
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
         this.posting = false
      })
      this.posting = false
    }
  }
}
</script>