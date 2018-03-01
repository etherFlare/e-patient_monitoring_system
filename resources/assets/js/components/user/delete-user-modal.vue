<template>
  <v-modal v-on:close="$emit('close')">
    <h3 slot="header">Delete Unit</h3>
    <div slot="body">
      <form ref="vForm" v-on:submit.prevent="doAction($event)">
        <template v-if="posting">...deleting</template>
        <template v-else>
          <div class="form-group">
            <label>mac_address</label>
            <input type="text" class="form-control" placeholder="..." :value="unit.mac_address"/>
          </div>
          <div class="form-group">
            <label>Commnet</label>
            <pre>{{unit.comment}}</pre>
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
  name:'delete-unit-modal',
  props: {
    deleteUnit: {
      required: true
    }
  },
  data() {
    return {
      posting: false,
      unit: (()=>{ return this.deleteUnit })()
    }
  },
  methods: {
    async doAction(event){
      const axiosOptions = {
        'url': '/unit/units/'+this.deleteUnit.id,
        'method': 'post',
        'params': {'_method': 'DELETE'}
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('unit-deleted')
        this.$emit('close')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }
  }
}
</script>