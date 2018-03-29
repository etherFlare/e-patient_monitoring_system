<template>
  <section>
    <modal
    v-model="showModal"
    title="Edit Unit"
    :keyboard="false"
    :backdrop="false"
    :footer="false"
    v-on:hide="$emit('close')"
    size="lg"
    >
    <div slot="default">
      <form v-if="unit" ref="vForm" v-on:submit.prevent="updateUnit($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="row">
            <div class="col-md-6">
              <p>
                <strong>
                  <i class="fa  fa-unit-plus margin-r-5"></i>Unit Activation Status
                </strong>
              </p>
              <div class="row">
                <div class="col-xs-3">
                  <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round "></span>
                  </label>
                </div>
                <div class="col-xs-9">
                  <strong><i class="fa fa-file-text-o margin-r-5"></i>Used By</strong>
                  <p>{{ unit.unit_is_inuse }}</p>
                </div>
              </div>
              <hr>
              <div class="form-group" :class="{'has-error': !unit.mac_address}">
                <label><i class="fa fa-mobile-phone margin-r-5"></i>Mac Address</label>
                <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address"/>
              </div>
              <hr>
              <div class="form-group" :class="{'has-error': !unit.comment}">
                <label>Comment</label>
                <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="unit.comment"></textarea>
              </div>
            </div>
            <div class="col-md-6">

              <p>
                <strong>
                  <i class="fa  fa-unit-plus margin-r-5"></i>Unit Oximeter Status
                </strong>
              </p>
              <div class="row">
                <div class="col-xs-3">
                  <label class="switch">
                    <input type="checkbox"   checked>
                    <span class="slider round "></span>
                  </label>
                </div>
                <div class="col-xs-9">
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                  <dropdown class="form-group">
                    <div class="input-group">
                      <input class="form-control" type="text" :value="this.time.toTimeString()" readonly="readonly">
                      <div class="input-group-btn">
                        <btn class="dropdown-toggle"><i class="glyphicon glyphicon-time"></i></btn>
                      </div>
                    </div>
                    <template slot="dropdown">
                      <li style="padding: 10px">
                        <time-picker v-model="time"/>
                      </li>
                    </template>
                  </dropdown>
                </div>
              </div>
              <p>
                <strong>
                  <i class="fa  fa-unit-plus margin-r-5"></i>Account Sphygmomanometer Status
                </strong>
              </p>
              <div class="row">
                <div class="col-xs-3">
                  <label class="switch">
                    <input type="checkbox"   checked>
                    <span class="slider round "></span>
                  </label>
                </div>
                <div class="col-xs-9">
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                  <dropdown class="form-group">
                    <div class="input-group">
                      <input class="form-control" type="text" :value="this.time.toTimeString()" readonly="readonly">
                      <div class="input-group-btn">
                        <btn class="dropdown-toggle"><i class="glyphicon glyphicon-time"></i></btn>
                      </div>
                    </div>
                    <template slot="dropdown">
                      <li style="padding: 10px">
                        <time-picker v-model="time"/>
                      </li>
                    </template>
                  </dropdown>

                </div>
              </div>
              <p>
                <strong>
                  <i class="fa  fa-unit-plus margin-r-5"></i>Account Thermometer Status
                </strong>
              </p>
              <div class="row">
                <div class="col-xs-3">
                  <label class="switch">
                    <input type="checkbox"    checked>
                    <span class="slider round "></span>
                  </label>
                </div>
                <div class="col-xs-9">
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                  <dropdown class="form-group">
                    <div class="input-group">
                      <input class="form-control" type="text" :value="this.time.toTimeString()" readonly="readonly">
                      <div class="input-group-btn">
                        <btn class="dropdown-toggle"><i class="glyphicon glyphicon-time"></i></btn>
                      </div>
                    </div>
                    <template slot="dropdown">
                      <li style="padding: 10px">
                        <time-picker v-model="time"/>
                      </li>
                    </template>
                  </dropdown>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer text-right" >
            <div class="row">
              <button class="btn btn-default pull-left col-md-4" type="button" v-on:click="dismiss=true">CANCEL</button>
              <button class="btn pull-right col-md-4" :class="{'btn-primary': canPost, 'btn-danger': !canPost}" type="submit">UPDATE</button>
            </div>
          </div>
        </template>
      </form>
    </div>
  </modal>
  <!--verification modal -->
  <modal
  v-model="dismiss"
  :transition-duration="0"
  :header="false"
  >
  <h3>WARNING! DISMISSING UPDATE</h3>
  <div slot="footer">
    <button class="btn btn-success pull-left col-md-4" type="button" v-on:click="dismiss=false" data-action="auto-focus">Back to Update</button>
    <button class="btn btn-danger pull-right col-md-4" type="button" v-on:click="$emit('close')">Cancel Update</button>
  </div>
</modal>
<!--verification modal end-->
</section>
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
      dismiss:false,
      showModal: true,
      posting: false,
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
      this.showModal = false
    }
  }
}
</script>