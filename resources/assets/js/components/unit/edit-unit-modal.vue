<template>
  <section>
    <modal v-model="showModal" title="EditUnit" :keyboard="false" :backdrop="false" :footer="false" v-on:hide="$emit('close')" size="lg">
      <div slot="default">
        <form v-if="unit" ref="vForm" v-on:submit.prevent="updateUnit($event)">
          <template v-if="isBusy">
            <img class="animated-box  img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
          </template>
          <template v-else>
            <div class="row">
              <div class="col-md-6">
                <p><strong><i class="fa  fa-circle-o margin-r-5"></i>Activation Status</strong></p>
                <div class="row">
                  <div class="col-xs-3">
                    <label class="switch">
                      <input type="checkbox" checked v-model="unit.unit_is_active"/>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
                <hr>
                <div class="form-group" :class="{'has-error': !unit.mac_address}">
                  <label><i class="fa fa-mobile-phone margin-r-5"></i>Mac Address</label>
                  <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address" v-mask="['XX:XX:XX:XX:XX:XX']"/>
                </div>
                <hr>
                <div class="form-group" >
                  <label>Comment</label>
                  <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="unit.comment"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <p>
                  <strong>
                    <i class="fa  fa-circle-o margin-r-5"></i>Label
                  </strong>
                </p>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group" :class="{'has-error': !unit.label}">
                      <input type="text" class="form-control" placeholder="..." v-model="unit.label"/>
                    </div>
                  </div>
                </div>
                <p>
                  <strong>
                    <i class="fa  fa-circle-o margin-r-5"></i> Unit Oximeter Status
                  </strong>
                </p>
                <div class="row">
                  <div class="col-xs-3">
                    <label class="switch">
                      <input type="checkbox" checked v-model="unit.oximeter_is_active"/>
                      <span class="slider round "></span>
                    </label>
                  </div>
                  <div class="col-xs-9">
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                    <input type="text" class="form-control" placeholder="..." v-model="unit.oximeter_delay"/>
                  </div>
                </div>
                <p>
                  <strong>
                    <i class="fa fa-circle-o margin-r-5"></i> Account Sphygmomanometer Status
                  </strong>
                </p>
                <div class="row">
                  <div class="col-xs-3">
                    <label class="switch">
                      <input type="checkbox" checked v-model="unit.bp_is_active"/>
                      <span class="slider round "></span>
                    </label>
                  </div>
                  <div class="col-xs-9">
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                    <input type="text" class="form-control" placeholder="..." v-model="unit.bp_delay"/>
                  </div>
                </div>
                <p>
                  <strong>
                    <i class="fa  fa-circle-o margin-r-5"></i>Account Thermometer Status
                  </strong>
                </p>
                <div class="row">
                  <div class="col-xs-3">
                    <label class="switch">
                      <input type="checkbox" checked v-model="unit.thermometer_is_active"/>
                      <span class="slider round "></span>
                    </label>
                  </div>
                  <div class="col-xs-9">
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                    <input type="text" class="form-control" placeholder="..." v-model="unit.thermometer_delay"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer text-right" >
              <div class="row">
                <button class="btn btn-danger pull-left col-md-4" type="button" v-on:click="$emit('close')">Cancel </button>
                <button class="btn pull-right col-md-4" :class="{'btn-primary': canPost, 'btn-danger': !canPost}" type="submit">UPDATE</button>
              </div>
            </div>
          </template>
        </form>
      </div>
    </modal>
  </section>
</template>
<script>
import {mask} from 'vue-the-mask'
export default {
  directives: { mask },
  name: 'edit-unit-modal',
  props: {
    editUnit: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isBusy: false,
      errors: null,
      unit: (()=>{ return Object.assign({}, this.editUnit) })(),
      time: new Date(''),
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
    hasError(field) {
      const errors = this.errors
      if(!errors) return false
        return Object.keys(errors).map(key=>key).includes(field)
    },
    async updateUnit(event){
      const axiosOptions = {
        'url': '/unit/units/'+this.editUnit.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': {unit: this.unit}
      }
      this.errors = null
      this.isBusy = true
      this.result = {}
      this.message = {}
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('unit-updated')
        this.isBusy = false
        this.showModal = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.$toaster.error(error.response.data.message)
        this.isBusy = false
        return Promise.reject(error.response);
      })
      this.isBusy = false
    }
  }
}
</script>