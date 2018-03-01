<template>
  <v-modal v-on:close="$emit('close')">
    <h3 slot="header">New Unit</h3>
    <div slot="body">
      <form ref="vForm" v-on:submit.prevent="postNewUnit($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !unit.mac_address}">
            <label>mac_address</label>
            <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address"/>
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
  name: 'new-unit-modal',
  data() {
    return {
      posting: false,
      unit: {
        mac_address: ''
      
      }
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.unit).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewUnit(event){
      const axiosOptions = {
        'url': '/unit/units',
        'method': 'post',
        'data': this.unit
      }
      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.unit = {mac_address: ''}
        this.$emit('unit-created')
        setTimeout(() => this.$emit('close'), 500)
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }
  }
}
</script>