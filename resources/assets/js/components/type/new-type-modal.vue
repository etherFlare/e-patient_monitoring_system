<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Type"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewType($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !type.name}">
            <label>name</label>
            <input type="text" class="form-control" placeholder="..." v-model="type.name"/>
          </div>
          <div class="form-group" :class="{'has-error': !type.description}">
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="type.description"></textarea>
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
  name: 'new-type-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      type: {
        name: '',
        description: ''
      }
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.type).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewType(event){
      const axiosOptions = {
        'url': '/type/types',
        'method': 'post',
        'data': this.type
      }
 console.log( this.type); 

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.type = {name: '', description: ''}
        this.$emit('type-created')
        setTimeout(() => this.$emit('close'), 500)
console.log( this.type); 

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