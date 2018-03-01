<template id="post-list">
  <div>
    <div class="row">
      <div class="pull-right">
        <div class="form-group">
          <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreatePostModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
          Add new Post</a>
        </div>
      </div>
      <form v-on:submit.prevent="getPosts($event)">
        <div class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" v-model="searchTerm"/>
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">search</button>
              </div>
            </div>
          </div> 
        </div>
        <p>{{searchTerm}}</p>
      </form>
      <heart-beat v-if="on_load"></heart-beat>
      <div v-if="!loading"> 
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Post Title</th>
              <th>Post Body</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th class="col-md-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(post, index) in posts">
              <td>{{ index + 1 }}</td>
              <td>{{ post.title }}</td>
              <td>{{ post.body }}</td>
              <td>{{ post.created_at | moment('LLLL')}} <code>{{ post.created_at | moment('from')}}</code></td>
              <td>{{ post.updated_at }}</td>
              <td>
                <button type="button" class="btn btn-info btn-xs" v-on:click="showPostModalComponent($event, post)"><i class="fa fa-eye"></i> Show</button>
                <button type="button" class="btn btn-warning btn-xs" v-on:click="showEditPostModalComponent($event, post)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                <button type="button" class="btn btn-danger btn-xs" v-on:click="showDeletePostModalComponent($event, post)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                <hr />
<!--
<router-link class="btn btn-info btn-xs" v-bind:to="{name: 'Viewpost', params: {id: post.id}}"><i class="fa fa-eye" aria-hidden="true"></i> Show</router-link> 
<router-link class="btn btn-warning btn-xs" v-bind:to="{name: 'Editpost', params: {id: post.id}}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</router-link>
<router-link class="btn btn-danger btn-xs" v-bind:to="{name: 'Deletepost', params: {id: post.id}}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</router-link>
-->
</td>
</tr>
</tbody>
</table>
</div>
</div>
<new-post-modal ref="showCreatePostModal" v-if="showCreatePostModal" v-on:close="showCreatePostModal = false" v-on:post-created="postCreated"></new-post-modal>
<edit-post-modal ref="showEditPostModal" :edit-post="post" v-if="showEditPostModal" v-on:post-updated="getPosts" v-on:close="showEditPostModal = false"></edit-post-modal>
<delete-post-modal ref="showDeletePostModal" :delete-post="post" v-if="showDeletePostModal" v-on:post-deleted="getPosts" v-on:close="showDeletePostModal = false"></delete-post-modal>
<v-modal ref="showPostModal" v-if="showPostModal" v-on:close="showPostModal = false">
  <h3 slot="header">POST</h3> 
  <div slot="body">
    <strong>{{ post.title }}</strong>
    <p>{{ post.body }}</p> 
    <div>{{post.created_at | moment('LLLL')}}</div>
    <code>{{post.created_at | moment('from')}}</code>
  </div> 
</v-modal>
</div>
</template>
<script>
export default {
  data() {
    return {
      on_load: true,
      post: null,
      showCreatePostModal: false,
      showEditPostModal: false,
      showDeletePostModal: false,
      showPostModal: false,
      searchTerm: ''
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getPosts().then((response)=>{
        this.on_load = false
      })
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    posts() {
      return this.$store.getters.posts
    },
    filteredPosts: function(){
      if(this.posts.length) {
        return this.posts;
      }
    }
  },
  methods: {
    postCreated() { 
      this.getPosts() 
    },
    showCreatePostModalComponent(event) {
      this.showCreatePostModal = true
    },
    showEditPostModalComponent(event, post) {
      this.post = post
      this.$nextTick(() => { 
        this.showEditPostModal = true
      })
    },
    showDeletePostModalComponent(event, post) {
      this.post = post
      this.$nextTick(() => { 
        this.showDeletePostModal = true
      })
    },
    showPostModalComponent(event, post) {
      this.post = post
      this.$nextTick(() => { 
        this.showPostModal = true
      })
    },
    getPosts(event) {
      return this.$store.dispatch('getPosts', { 'search': this.searchTerm })
    }
  },
}
</script>