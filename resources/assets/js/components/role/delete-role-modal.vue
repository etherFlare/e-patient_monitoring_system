<template>
  <v-modal v-on:close="$emit('close')">
    <h3 slot="header">Delete Role</h3>
    <div slot="body">
      <form ref="vForm" v-on:submit.prevent="doAction($event)">
        <template v-if="posting">...deleting</template>
        <template v-else>
          <div class="form-group">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." :value="role.title"/>
          </div>
          <div class="form-group">
            <label>description</label>
            <pre>{{role.description}}</pre>
          </div>
          <div class="text-right">
            <button class="btn btn-danger" type="submit">CONFIRM</button>
          </div>
        </template>
      </form>
    </div>
  </v-modal>
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
      posting: false,
      role: (()=>{ return this.deleteRole })()
    }
  },
  methods: {
    async doAction(event){
      const axiosOptions = {
        'url': '/role/roles/'+this.deleteRole.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('role-deleted')
        this.$emit('close')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }
  }
}
</script>