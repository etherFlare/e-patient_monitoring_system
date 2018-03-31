<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Location"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewLocation($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !location.name}">
            <label>name</label>
            <input type="text" class="form-control" placeholder="..." v-model="location.name"/>
          </div>
          <div class="form-group" :class="{'has-error': !location.description}">
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="location.description"></textarea>
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
  name: 'new-location-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      location: {
        name: '',
        description: ''
      }
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.location).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewLocation(event){
      const axiosOptions = {
        'url': '/location/locations',
        'method': 'post',
        'data': this.location
      }
 console.log( this.location); 

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.location = {name: '', description: ''}
        this.$emit('location-created')
        setTimeout(() => this.$emit('close'), 500)
console.log( this.location); 

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