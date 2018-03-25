<template id="post-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
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
        </div>
        <div class="box-body">
          <heart-beat v-if="on_load"></heart-beat>
          <div v-if="!loading"> 
            <table  id="ex1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Post Title</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(post, index) in posts">
                  <td>{{ index + 1 }}</td>
                  <td>{{ post.title }}</td>
                  <td>{{ post.created_at | moment('LLLL')}} <code>{{ post.created_at | moment('from')}}</code></td>
                  <td>{{ post.updated_at }}</td>
                  <td class="row"> 
                    <btn size="xs" type="primary" class="col-xs-3" style="margin-left:3px;margin-right:3px;" v-on:click="showPostModalComponent($event, post)"><i class="fa fa-eye"></i> Show</btn>
                    <btn size="xs" type="warning"  class="col-xs-3"style="margin-left:3px;margin-right:3px;" v-on:click="showEditPostModalComponent($event, post)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
                    <btn size="xs" type="danger"  class="col-xs-3" style="margin-left:3px;margin-right:3px;"  v-on:click="showDeletePostModalComponent($event, post)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
        </div>
        <new-post-modal ref="showCreatePostModal" v-if="showCreatePostModal" v-on:close="showCreatePostModal = false" v-on:post-created="postCreated" ></new-post-modal>
        <edit-post-modal v-if="showEditPostModal" v-on:close="showEditPostModal = false" :edit-post="post" v-on:post-updated="getPosts"></edit-post-modal> 
        <delete-post-modal ref="showDeletePostModal" :delete-post="post" v-if="showDeletePostModal" v-on:post-deleted="getPosts" v-on:close="showDeletePostModal = false"></delete-post-modal>

        <!--show modal-->
        <modal ref="showPostModal" v-if="showPostModal" v-model="showPostModal"  auto-focus v-on:hide="$emit('close')" >
          <h3 slot="title">POST</h3>       
          <strong>{{ post.title }}</strong>
          <p>{{ post.body }}</p> 
          <div>{{post.created_at | moment('LLLL')}}</div>
          <code>{{post.created_at | moment('from')}}</code>
          <div slot="footer">
           <btn type="warning"  class="" v-on:click="showEditPostModalComponent($event, post)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
              <btn type="danger"  class="" v-on:click="showDeletePostModalComponent($event, post)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
              <btn  v-on:click="showPostModal=false" data-action="auto-focus">Cancel</btn>
          </div>
        </modal>
        <!--show modal end-->
      </div>
    </div>
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
      searchTerm: '',
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
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
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
