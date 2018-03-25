<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Unit"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewUnit($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !unit.mac_address}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address"/>
          </div>
          
          <div class="form-group" :class="{'has-error': !unit.oximeter_delay}">
             <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox">
                        </span>
                    <input type="text" class="form-control timepicker">
              </div>
          </div>
          <div class="form-group" :class="{'has-error': !unit.oximeter_delay}">
             <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox">
                        </span>
                    <input type="text" class="form-control">
              </div>
          </div>
          <div class="form-group" :class="{'has-error': !unit.oximeter_delay}">
             <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox">
                        </span>
                    <input type="text" class="form-control">
              </div>
          </div>
         <div class="form-group" :class="{'has-error': !unit.oximeter_delay}">
            <label>body</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="unit.oximeter_delay"></textarea>
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
  name: 'new-unit-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      unit: {
        mac_address:'',
        unit_is_active:'',
        unit_is_inuse:'',
        oximeter_is_active:'',
        bp_is_active:'',
        thermometer_is_active:'',
        oximeter_delay:'',
        bp_delay:'',
        thermometer_delay:'',
        comment:''
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
        this.unit = {
          mac_address:'',
          unit_is_active:'',
          unit_is_inuse:'',
          oximeter_is_active:'',
          bp_is_active:'',
          thermometer_is_active:'',
          oximeter_delay:'',
          bp_delay:'',
          thermometer_delay:'',
          comment:''
        }
        this.$emit('unit-created')
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