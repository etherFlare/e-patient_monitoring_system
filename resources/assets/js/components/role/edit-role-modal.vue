<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Role" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    >  
    <div slot="default">
      <form v-if="role" ref="vForm" v-on:submit.prevent="updateRole($event)">
        <template v-if="isbusy"><img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" ></template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !role.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="role.title"/>
          </div>
          <div class="form-group" >
            <label>description</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="role.description"></textarea>
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
export default {
  name: 'edit-role-modal',
  props: { 
    editRole: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false,
      role: (()=>{ return Object.assign({}, this.editRole) })()
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.role).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async updateRole(event){
      const axiosOptions = {
        'url': '/role/roles/'+this.editRole.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.role
      }
      this.isbusy = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('role-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.isbusy = false
      this.showModal = false
    }
  }
}
</script>