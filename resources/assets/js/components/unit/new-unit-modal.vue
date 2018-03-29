<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Unit"
   :footer="false"
   size="lg"
  >
      <form ref="vForm" v-on:submit.prevent="postNewUnit($event)">
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

      },
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
    async postNewUnit(event){
      const axiosOptions = {
        'url': '/unit/units',
        'method': 'post',
        'data': this.unit
      }
 console.log( this.unit); 

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.unit = {title: '', description: ''}
        this.$emit('unit-created')
        setTimeout(() => this.$emit('close'), 500)
console.log( this.unit); 

      }).catch(error => {
        this.$toaster.error(error.response.data.message)
         console.log( error.response.data.messagee);
         this.posting = false
      })
      this.posting = false
    }
  }
}
</script>