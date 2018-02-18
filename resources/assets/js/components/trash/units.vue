<template id="unit-list">
  <div>
    <div class="row">
      <div class="pull-right">
        <div class="form-group">
          
          <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateUnitModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
          Add new Unit</a>
          
        </div>
      </div>
      <form v-on:submit.prevent="getUnits($event)">
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
      <heart-beat v-if="loading"></heart-beat>
      <div v-if="!loading"> 
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Unit id</th>
              <th>Unid id</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th class="col-md-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(unit, index) in units">
              <td>{{ index + 1 }}</td>
              <td>{{ unit.id }}</td>
              <td>{{ unit.id }}</td>
              <td>{{ unit.created_at | moment('LLLL')}} <code>{{ unit.created_at | moment('from')}}</code></td>
              <td>{{ unit.updated_at }}</td>
              <td>
                <!--
               <button type="button" class="btn btn-info btn-xs" v-on:click="showUnitModalComponent($event, unit)"><i class="fa fa-eye"></i> Show</button>
               <button type="button" class="btn btn-warning btn-xs" v-on:click="showEditUnitModalComponent($event, unit)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
               <button type="button" class="btn btn-danger btn-xs" v-on:click="showDeleteUnitModalComponent($event, unit)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
               
               -->
             </td>
           </tr>
         </tbody>
       </table>
     </div>
   </div>
   
   <new-unit-modal ref="showCreateUnitModal" v-if="showCreateUnitModal" v-on:close="showCreateUnitModal = false" v-on:unit-created="unitCreated"></new-unit-modal>
   <edit-unit-modal ref="showEditUnitModal" :edit-unit="unit" v-if="showEditUnitModal" v-on:unit-updated="getUnits" v-on:close="showEditUnitModal = false"></edit-unit-modal>
   <delete-unit-modal ref="showDeleteUnitModal" :delete-unit="unit" v-if="showDeleteUnitModal" v-on:unit-deleted="getUnits" v-on:close="showDeleteUnitModal = false"></delete-unit-modal>
   <v-modal ref="showUnitModal" v-if="showUnitModal" v-on:close="showUnitModal = false">
    <h3 slot="header">UNIT</h3> 
    <div slot="body">
      <strong>{{ unit.id }}</strong>
      <p>{{ unit.id }}</p> 
      <div>{{unit.created_at | moment('LLLL')}}</div>
      <code>{{unit.created_at | moment('from')}}</code>
    </div> 
  </v-modal>
  
</div>
</template>
<script>
export default {
  data() {
    return {
      unit: null,
      showCreateUnitModal: false,
      showEditUnitModal: false,
      showDeleteUnitModal: false,
      showUnitModal: false,
      searchTerm: ''
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getUnits()
    })
  }, 
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    untis() {
      return this.$store.getters.units
    },
    filteredUnits: function(){
      if(this.units.length) {
        return this.units;
      }
    }
  },
  methods: {
    unitCreated() { 
      this.getUnits() 
    },
    showCreateUnitModalComponent(event) {
      this.showCreateUnitModal = true
    },
    showEditUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showEditUnitModal = true
      })
    },
    showDeleteUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showDeleteUnitModal = true
      })
    },
    showUnitModalComponent(event, unit) {
      this.unit = unit
      this.$nextTick(() => { 
        this.showUnitModal = true
      })
    },
    getUnits(event) {
      this.$store.dispatch('getUnits', { 'search': this.searchTerm })
    }
  },

  components: {
    'new-unit-modal': {
      template: `<v-modal v-on:close="$emit('close')">
      <h3 slot="header">New Unit</h3> 
      <div slot="body">
      <form ref="vForm" v-on:submit.prevent="unitNewUnit($event)">
      <template v-if="posting">...posting</template>
      <template v-else>
      <div class="form-group" :class="{'has-error': !unit.title}">
      <label>title</label>
      <input type="text" class="form-control" placeholder="..." v-model="unit.title"/>
      </div>
      <div class="form-group" :class="{'has-error': !unit.body}">
      <label>body</label>
      <textarea cols="30" rows="10" class="form-control" placeholder="..." v-model="unit.body"></textarea>
      </div>
      <div class="text-right">
      <button class="btn" :class="{'btn-default': canPost, 'btn-danger': !canPost}" type="submit">SUBMIT</button>
      </div>
      </template>
      </form>
      </div> 
      </v-modal>`,
      data() {
        return {
          posting: false, 
          unit: {
            id: '',
            id: ''
          }
        }
      },
      computed: { 
        canPost(){
          let result = true
          Object.entries(this.unit).forEach(([attrIdx, attr])=>{
            if(attr === '') result = false  
          })
          return result
        }
      },
      methods: { 
        async postNewUnit(event){  
         const axiosOptions = {
          'url': '/post/posts/',
          'method': 'post',
          'data': this.post
        }
        this.posting = true 
        this.result = {}
        this.message = {}
        await axios(axiosOptions).then(async (response) => {
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
  },

  'edit-post-modal': {
    template: `<v-modal v-on:close="$emit('close')">
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
    </v-modal>`,
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
},
'delete-post-modal': {
  template: `<v-modal v-on:close="$emit('close')">
  <h3 slot="header">Delete Post</h3> 
  <div slot="body">
  <form ref="vForm" v-on:submit.prevent="doAction($event)"> 
  <template v-if="posting">...deleting</template>
  <template v-else>
  <div class="form-group">
  <label>title</label>
  <input type="text" class="form-control" placeholder="..." :value="post.title"/>
  </div>
  <div class="form-group">
  <label>body</label>
  <pre>{{post.body}}</pre>
  </div>
  <div class="text-right">
  <button class="btn btn-danger" type="submit">CONFIRM</button>
  </div>
  </template>
  </form>
  </div> 
  </v-modal>`,
  props: {
    deletePost: {
      required: true
    }
  },
  data() {
    return {
      posting: false, 
      post: (()=>{ return this.deletePost })()
    }
  }, 
  methods: { 
    async doAction(event){  
     const axiosOptions = {
      'url': '/post/posts/'+this.deletePost.id,
      'method': 'post',
      'params': {'_method': 'DELETE'}
    }
    this.posting = true 
    await axios(axiosOptions).then(async (response) => {
      this.$toaster.success(response.data.msg)
      this.$emit('post-deleted')
      this.$emit('close')
    }).catch(error => { 
      this.$toaster.error(error.response.data.message) 
    })
    this.posting = false
  }
}

}
}
}
</script>