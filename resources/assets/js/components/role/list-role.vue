<template id="role-list">
	<div>
		<div class="row">
			<div class="pull-right">
				<div class="form-group">
					<a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateRoleModalComponent($event)">
					Add new Role</a>
				</div>
			</div>
			<form v-on:submit.prevent="getRoles($event)">
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
							<th>title</th>
							<th>description</th>
							<th>Date Created</th>
							<th>Date Modified</th>
							<th class="col-md-2">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(role, index) in roles">
							<td>{{ role.title }}</td>
							<td>{{ role.description }}</td>
							<td>
								{{ role.created_at | moment('LLLL')}}
								<code>
									{{ role.created_at | moment('from')}}
								</code>
							</td>
							<td>{{ role.updated_at }}</td>
							<td>
								<button type="button" class="btn btn-info btn-xs" v-on:click="showRoleModalComponent($event, role)"><i class="fa fa-eye"></i> Show</button>
								<button type="button" class="btn btn-warning btn-xs" v-on:click="showEditRoleModalComponent($event, role)"> Edit</button>
								<button type="button" class="btn btn-danger btn-xs" v-on:click="showDeleteRoleModalComponent($event, role)"> Delete</button>
								<hr />

							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<new-role-modal ref="showCreateRoleModal" v-if="showCreateRoleModal" v-on:close="showCreateRoleModal = false" v-on:role-created="RoleCreated"></new-role-modal>

		<edit-role-modal ref="showEditRoleModal" :edit-role="role" v-if="showEditRoleModal" v-on:role-updated="getRoles" v-on:close="showEditRoleModal = false"></edit-role-modal>
		<delete-role-modal ref="showDeleteRoleModal" :delete-role="role" v-if="showDeleteRoleModal" v-on:role-deleted="getRoles" v-on:close="showDeleteRoleModal = false"></delete-role-modal>
		<v-modal ref="showRoleModal" v-if="showRoleModal" v-on:close="showRoleModal = false">
			<h3 slot="header">ROLE</h3>
			<div slot="body">
				<strong>{{ role.title }}</strong>
				<p>{{ role.description }}</p>
				<div>{{role.created_at | moment('LLLL')}}</div>
				<code>{{role.created_at | moment('from')}}</code>
			</div>

		</v-modal>


	</div>
</template>
<script>
export default {
	data() {
		return {
			on_load: true,
			showCreateRoleModal: false,
			showEditRoleModal: false,
			showDeleteRoleModal: false,
			showRoleModal: false,
			role: null,
			searchTerm: ''
		}
	},
	mounted() {
		this.$nextTick(()=>{
			this.getRoles().then((response)=>{
				this.on_load = false
			})
		})
	},
	computed: {
		loading() {
			return this.$store.getters.loading
		},
		roles() {
			return this.$store.getters.roles
		},
		filteredRoles: function(){
			if(this.roles.length) {
				return this.roles;
			}
		}
	},
	methods: {
		roleCreated() {
			this.getRoles()
		},
		showCreateRoleModalComponent(event) {
			this.showCreateRoleModal = true
		},
		showEditRoleModalComponent(event, role) {
			this.role = role
			this.$nextTick(() => {
				this.showEditRoleModal = true
			})
		},
		showDeleteRoleModalComponent(event, role) {
			this.role = role
			this.$nextTick(() => {
				this.showDeleteRoleModal = true
			})
		},
		showRoleModalComponent(event, role) {
			this.role = role
			this.$nextTick(() => {
				this.showRoleModal = true
			})
		},
		getRoles(event) {
			return this.$store.dispatch('getRoles', { 'search': this.searchTerm })
		}
	},
}
</script>