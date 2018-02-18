<template>
    <v-modal v-on:close="$emit('close')">
      <h3 slot="header">Edit Post</h3>
      <div slot="body">
        <form ref="vForm" v-on:submit.prevent="updatePost($event)">
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
              <button class="btn btn-default pull-left" type="button" v-on:click="$emit('close')">CANCEL</button>
              <button class="btn" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">UPDATE</button>
            </div>
          </template>
        </form>
      </div>
    </v-modal>
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
      posting: false,
      post: (()=>{ return this.editPost })()
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
      this.posting = true
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('post-updated')
      }).catch(error => {
        this.$toaster.error(error.response.data.message)
      })
      this.posting = false
    }

  }
}
</script>