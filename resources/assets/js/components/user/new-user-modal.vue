<template>
  <modal
  v-model="showModal"
  v-on:hide="$emit('close')"
  title="New User"
  :footer="false"
  size="lg"
  >
  <form ref="vForm" v-on:submit.prevent="postNewUser($event)">
    <template v-if="posting">
       <img class="animated-box profile-user-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="User profile picture" >
    </template>
    <template v-else>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group col-md-4" :class="{'has-error': !user.first_name}">
            <label>First Name</label>
            <input type="text" class="form-control" placeholder="..." v-model="user.first_name"/>
          </div>
          <div class="form-group col-md-4" :class="{'has-error': !user.middle_name}">
            <label>Middle Name</label>
            <input type="text" class="form-control" placeholder="..." v-model="user.middle_name"/>
          </div>
          <div class="form-group col-md-4" :class="{'has-error': !user.last_name}">
            <label>Surname</label>
            <input type="text" class="form-control" placeholder="..." v-model="user.last_name"/>
          </div>
          <div class="form-group " :class="{'has-error': !user.contact_number}">
            <label>Phone Number</label>
            <input type="text" class="form-control" placeholder="..." v-model="user.contact_number"/>
          </div>
          <div class="form-group">
            <label class="col-md-12">Role</label>
            <multi-select  v-model="selected" :options="options"/>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group " :class="{'has-error': !user.email}">
            <label>Email Address</label>
            <input type="email" class="form-control" placeholder="..." v-model="user.email"/>
          </div>
          <div class="form-group " :class="{'has-error': !user.password}">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="updated as lastname was added" v-model="user.password"/>
          </div>
          <div class="form-group" :class="{'has-error': !user.comment}">
            <label>Comment</label>
            <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="user.comment"></textarea>
          </div>
        </div>
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
  name: 'new-user-modal',
  data() {
    return {
      showModal: true,
      posting: false,
      user: {
        title: '',
        description: ''
      },
      selected: [],
      options: [
      {value: 1, label:'Option1'},
      {value: 2, label:'Option2'},
      {value: 3, label:'Option3'},
      {value: 4, label:'Option4'},
      {value: 5, label:'Option5'}
      ]
    }
  },
  computed: {
    canPost(){
      let result = true
      Object.entries(this.user).forEach(([attrIdx, attr])=>{
        if(attr === '') result = false
      })
      return result
    }
  },
  methods: {
    async postNewUser(event){
      const axiosOptions = {
        'url': '/user/users',
        'method': 'post',
        'data': this.user
      }
      console.log( this.user);

      this.posting = true
      this.result = {}
      this.message = {}
      return await axios(axiosOptions).then(async (response) => {
        this.$toaster.success(response.data.msg)
        this.user = {title: '', description: ''}
        this.$emit('user-created')
        setTimeout(() => this.$emit('close'), 500)
        console.log( this.user);

      }).catch(error => {
        this.$toaster.error(error.response.data.message)
        console.log( error.response.data.messagee);
        this.posting = false
      })
      this.posting = false
    }
  }
}
</script>