<template>
    <v-modal v-on:close="$emit('close')">
      <h3 slot="header">Edit Unit</h3>
      <div slot="body">
        <form ref="vForm" v-on:submit.prevent="updateUnit($event)">
          <template v-if="posting">...posting</template>
          <template v-else>
            <div class="form-group" :class="{'has-error': !unit.mac_address}">
              <label>mac_address</label>
              <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address"/>
            </div>
            <div class="form-group" :class="{'has-error': !unit.comment}">
              <label>Comment</label>
              <textarea cols="30" rows="10" class="form-control" placeholder="..." v-model="unit.comment"></textarea>
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
  name: 'edit-unit-modal',
  props: {
    editUnit: {
      required: true
    }
  },
  data() {
    return {
      posting: false,
      unit: (()=>{ return this.editUnit })()
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
    async updateUnit(event){
      const axiosOptions = {
        'url': '/unit/units/'+this.editUnit.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.unit
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('unit-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }

  }
}
</script>