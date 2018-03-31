<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Normal" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    >  
    <div slot="default">
      <form v-if="normal" ref="vForm" v-on:submit.prevent="updateNormal($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !normal.name}">
            <label>name</label>
            <input normal="text" class="form-control" placeholder="..." v-model="normal.name"/>
          </div>
          <div class="form-group" :class="{'has-error': !normal.description}">
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="normal.description"></textarea>
          </div>
          <div class="modal-footer text-right" >
            <div class="row">
              <button class="btn btn-default pull-left col-md-4" normal="button" v-on:click="dismiss=true">CANCEL</button>
              <button class="btn pull-right col-md-4" :class="{'btn-primary': canPost, 'btn-danger': !canPost}" normal="submit">UPDATE</button>
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
    <button class="btn btn-success pull-left col-md-4" normal="button" v-on:click="dismiss=false" data-action="auto-focus">Back to Update</button> 
    <button class="btn btn-danger pull-right col-md-4" normal="button" v-on:click="$emit('close')">Cancel Update</button> 
    
  </div>
</modal> 
<!--verification modal end-->
</section>
</template>
<script>
export default {
  name: 'edit-normal-modal',
  props: { 
    editNormal: {
      required: true
    }
  },
  data() {
    return {
      dismiss:false,
      showModal: true,
      posting: false,
      normal: (()=>{ return Object.assign({}, this.editNormal) })()
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.normal).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async updateNormal(event){
      const axiosOptions = {
        'url': '/normal/normals/'+this.editNormal.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.normal
      }
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('normal-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
      this.showModal = false
    }
  }
}
</script>name