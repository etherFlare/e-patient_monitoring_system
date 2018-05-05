<template>
  <modal  
  v-model="showModal" 
  v-on:hide="$emit('close')"
   title="New Post"
   :footer="false"
  >
      <form ref="vForm" v-on:submit.prevent="postNewPost($event)">
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
  name: 'new-post-modal',
  data() {
    return {
      showModal: true,
      isbusy: false,
      post: {
        title: '',
        body: ''
      }
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
    async postNewPost(event){
      const axiosOptions = {
        'url': '/post/posts',
        'method': 'post',
        'data': this.post
      }
      this.isbusy = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.post = {title: '', body: ''}
        this.$emit('post-created')
        setTimeout(() => this.$emit('close'), 500)
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
         this.isbusy = false
      })
      this.isbusy = false
    }
  }
}
</script>