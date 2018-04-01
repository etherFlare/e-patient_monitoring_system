<template>
  <section>
    <modal 
    v-model="showModal" 
    title="Edit Post" 
    :keyboard="false" 
    :backdrop="false" 
    :footer="false" 
    v-on:hide="$emit('close')"
    >  
    <div slot="default">
      <form v-if="post" ref="vForm" v-on:submit.prevent="updatePost($event)">
        <template v-if="isbusy"><img class="animated-box profile-patient-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Patient profile picture" ></template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !post.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="post.title"/>
          </div>
          <div class="form-group" :class="{'has-error': !post.body}">
            <label>body</label>
            <textarea cols="30" rows="5" class="form-control" placeholder="..." v-model="post.body"></textarea>
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
  name: 'edit-post-modal',
  props: { 
    editPost: {
      required: true
    }
  },
  data() {
    return {
      dismiss:false,
      showModal: true,
      isbusy: false,
      post: (()=>{ return Object.assign({}, this.editPost) })()
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.post).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async updatePost(event){
      const axiosOptions = {
        'url': '/post/posts/'+this.editPost.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': this.post
      }
      this.isbusy = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('post-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.isbusy = false
    }
  }
}
</script>