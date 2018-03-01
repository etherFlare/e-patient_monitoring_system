<template>
    <v-modal v-on:close="$emit('close')">
      <h3 slot="header">Edit Role</h3>
      <div slot="body">
        <form ref="vForm" v-on:submit.prevent="updateRole($event)">
          <template v-if="posting">...posting</template>
          <template v-else>
            <div class="form-group" :class="{'has-error': !role.title}">
              <label>title</label>
              <input type="text" class="form-control" placeholder="..." v-model="role.title"/>
            </div>
            <div class="form-group" :class="{'has-error': !role.description}">
              <label>description</label>
              <textarea cols="30" rows="10" class="form-control" placeholder="..." v-model="role.description"></textarea>
            </div>
            <div class="text-right">
              <button class="btn btn-default pull-left" type="button" v-on:click="$emit('close')">CANCEL</button>
              <button class="btn" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">UPDATE</button>
            </div>
          </template>
        </form>
      </div>
    </v-modal>
</template>
<script>
export default {
  name: 'edit-role-modal',
  props: {
    editRole: {
      required: true
    }
  },
  data() {
    return {
      posting: false,
      role: (()=>{ return this.editRole })()
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
    async updateRole(event){
      const axiosOptions = {
        'url': '/role/roles/'+this.editRole.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.role
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('role-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }

  }
}
</script>