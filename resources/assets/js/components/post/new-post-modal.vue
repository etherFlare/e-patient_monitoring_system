<template>
  <v-modal v-on:close="$emit('close')">
    <h3 slot="header">New Post</h3>
    <div slot="body">
      <form ref="vForm" v-on:submit.prevent="postNewPost($event)">
        <template v-if="posting">...posting</template>
        <template v-else>
          <div class="form-group" :class="{'has-error': !post.title}">
            <label>title</label>
            <input type="text" class="form-control" placeholder="..." v-model="post.title"/>
          </div>
          <div class="form-group" :class="{'has-error': !post.body}">
            <label>body</label>
            <textarea cols="30" rows="10" class="form-control" placeholder="..." v-model="post.body"></textarea>
          </div>
          <div class="text-right">
            <button class="btn" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">SUBMIT</button>
          </div>
        </template>
      </form>
    </div>
  </v-modal>
</template>
<script>
export default {
  name: 'new-post-modal',
  data() {
    return {
      posting: false,
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
      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.post = {title: '', body: ''}
        this.$emit('post-created')
        setTimeout(() => this.$emit('close'), 500)
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }
  }
}
</script>