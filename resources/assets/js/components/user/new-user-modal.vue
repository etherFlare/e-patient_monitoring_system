<template>
    <modal v-model="showModal" v-on:hide="$emit('close')" title="NewUser" :footer="false" size="lg">
    <form ref="vForm" v-on:submit.prevent="postNewUser($event)">
        <template v-if="isBusy">
            <img class="animated-box profile-user-img img-responsive img-circle " src="/img/heart-beat.png" alt="User profile picture" >
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
                    <div class="form-group " :class="{'has-error': !user.password || hasError('user.password')}">
                        <label>Password</label>
                        <input type="text" class="form-control" placeholder="..." v-model="user.password"/>
                        <template v-if="hasError('user.password')">
                            <p class="small text-red" v-for="(line, errorIdx) in errors['user.password']" :key="errorIdx">{{line}}</p>
                        </template>
                    </div>
                     <div class="form-group">
                           <label>Confirm Password</label>
                        <input type="text" class="form-control" placeholder="retype password" v-model="user.password_confirmation"/>
                        <template v-if="hasError('user.password_confirmation')">
                            <p class="small text-red" v-for="(line, errorIdx) in errors['user.password_confirmation']" :key="errorIdx">{{line}}</p>
                        </template>
                     </div>
                    <div class="form-group" >
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
const blankUserData = () => {
    return {
        first_name: 'teddy',
        middle_name: 'black',
        last_name: 'white',
        contact_number: '090909090',
        email: 'sample@local.test',
        password: '1234',
        comment: 'sample',
        roles: []
      /*  first_name: '',
        middle_name: '',
        last_name: '',
        contact_number: '',
        email: '',
        password: '',
        comment: '',
        roles: []*/
    }
}
export default {
    name: 'new-user-modal',
    data() {
        return {
            showModal: true,
            isBusy: false,
            user: blankUserData(),
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
        canPost() {
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
        async postNewUser(event){
            const axiosOptions = {
                'url': '/user/users',
                'method': 'post',
                'data': {user: this.user}
            }
            this.errors = null
            this.isBusy = true
            this.result = {}
            this.message = {}
            return await axios(axiosOptions).then( (response) => {
                this.user = blankUserData()
                this.$toaster.success(response.data.msg)
                this.$emit('user-created')
                this.isBusy = false
                this.showModal = false
            }).catch(error => {
                this.errors = error.response.data.errors
                this.$toaster.error(error.response.data.message)
                this.isBusy = false
                console.log(error.response);
                return Promise.reject(error.response);
            })
            this.isBusy = false
        }
    },
    created () {
        this.getRoles()
    }
}
</script>
