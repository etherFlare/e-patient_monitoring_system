<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Type" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    >  
    <div slot="default">
      <form v-if="type" ref="vForm" v-on:submit.prevent="updateType($event)">
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
  name: 'edit-type-modal',
  props: { 
    editType: {
      required: true
    }
  },
  data() {
    return {
      dismiss:false,
      showModal: true,
      posting: false,
      type: (()=>{ return Object.assign({}, this.editType) })()
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
    async updateType(event){
      const axiosOptions = {
        'url': '/type/types/'+this.editType.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.type
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('type-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
      this.showModal = false
    }
  }
}
</script>name