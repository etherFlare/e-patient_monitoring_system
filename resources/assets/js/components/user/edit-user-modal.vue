<template>
  <section>
    <modal v-model="showModal" title="EditUser" :keyboard="false" :backdrop="false" :footer="false" v-on:hide="$emit('close')" size="lg">
      <div slot="default">
        <form v-if="user" ref="vForm" v-on:submit.prevent="updateUser($event)">
          <template v-if="isBusy">
            <img class="animated-box profile-user-img img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
          </template>
          <template v-else>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group" :class="{'has-error': !user.first_name}">
                      <label>First Name</label>
                      <input type="text" class="form-control" placeholder="..." v-model="user.first_name"/>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" :class="{'has-error': !user.middle_name}">
                      <label>Middle Name</label>
                      <input type="text" class="form-control" placeholder="..." v-model="user.middle_name"/>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" :class="{'has-error': !user.last_name}">
                      <label>Surname</label>
                      <input type="text" class="form-control" placeholder="..." v-model="user.last_name"/>
                    </div>
                  </div>
                </div>
                <div class="form-group " :class="{'has-error': !user.contact_number}">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" placeholder="..." v-model="user.contact_number"/>
                </div>
                <div class="form-group">
                  <label class="col-md-12">Role</label>
                  <multi-select v-model="user.roles" :options="rolesOption"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group " :class="{'has-error': !user.email || hasError('user.email')}">
                  <label>Email Address</label>
                  <input type="email" class="form-control" placeholder="..." v-model="user.email"/>
                  <template v-if="hasError('user.email')">
                    <p class="small text-red" v-for="(line, errorIdx) in errors['user.email']" :key="errorIdx">{{line}}</p>
                  </template>
                </div>
               <!--  <div class="form-group " :class="{'has-error': !user.password || hasError('user.password')}">
                  <label>Password</label>
                  <input type="text" class="form-control" placeholder="updated as lastname was added" v-model="user.password"/>
                  <template v-if="hasError('user.password')">
                    <p class="small text-red" v-for="(line, errorIdx) in errors['user.password']" :key="errorIdx">{{line}}</p>
                  </template>
                </div> -->
                <div class="form-group" >
                  <label>Comment</label>
                  <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="user.comment"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer text-right" >
              <div class="row">
                <button class="btn btn-default pull-left col-md-4" type="button" v-on:click="$emit('close')">Cancel Update</button>
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
  name: 'edit-user-modal',
  mounted() {
      this.getRoles()
    },
  props: {
    editUser: {
      required: true
    }
  },
  data() {
    return {
      showModal: true,
      isbusy: false,
      user: (()=>{ return Object.assign({}, this.editUser) })(),
      isBusy: false,
      roles: null,
      errors: null
    }
  },
  computed: {
    emailHasError() {
      return this.hasError('user.email')
    },
    rolesOption() {
      if(Boolean(this.roles))
      {
        return this.roles.data.map(role => { return {label: role.title, value: role.id} } )
      }
      return []
    },
    canPost(){
      let result = true
      Object.entries(this.user).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    hasError(field) {
      const errors = this.errors
      if(!errors) return false
        return Object.keys(errors).map(key=>key).includes(field)
    },
    async getRoles() {
      const axiosOptions = {
        'url': '/role/roles',
        'method': 'get'
      }
      await axios(axiosOptions).then((response) => {
        this.roles = response.data
      }).catch(error => {
        this.roles = null
        error()
      })
    },
    async updateUser(event){
      const axiosOptions = {
        'url': '/user/users/'+this.editUser.id,
        'method': 'post',
        'params': {'_method': 'PUT'},
        'data': {user: this.user}
      }
      this.errors = null
      this.isBusy = true
      this.result = {}
      this.message = {}
      await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.$emit('user-updated')
        this.isBusy = false
        this.showModal = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isBusy = false
        return Promise.reject(error.response);
      })
      this.isBusy = false
    }

  }
}
</script>