<template>
  <v-modal v-on:close="$emit('close')">
    <h3 slot="header">New Role</h3>
    <div slot="body">
      <form ref="vForm" v-on:submit.prevent="postNewRole($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !role.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="role.title"/>
          </div>
         <div class="form-group" :class="{'has-error': !role.description}">
            <label>description</label>
            <input type="text" class="form-control" placeholder="..." v-model="role.description"/>
          </div>
          <div class="text-right">
            <button class="btn" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">SUBMIT</button>
          </div>
        </template>
      </form>
    </div>
  </v-modal>
</template>
<script>
export default {
  name: 'new-role-modal',
  data() {
    return {
      posting: false,
      role: {
        mac_address: ''
      
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
      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.role = {mac_address: ''}
        this.$emit('role-created')
        setTimeout(() => this.$emit('close'), 500)
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }
  }
}
</script>