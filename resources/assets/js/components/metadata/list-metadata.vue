<template id="unit-list">
	<div>
		<div class="row">
			<div class="pull-right">
				<div class="form-group">
					<a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreateUnitModalComponent($event)">
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
			<heart-beat v-if="on_load"></heart-beat>
			<div v-if="!loading">
				<table class="table">
					<thead>
						<tr>
							<th>mac address</th>
							<th>is active</th>
							<th>in use</th>
							<th>oximeter</th>
							<th>bp</th>
							<th>thermometer</th>
							<th>oximeter Delay</th>
							<th>bp Delay</th>
							<th>thermometer Delay</th>
							<th>Date Created</th>
							<th>Date Modified</th>
							<th class="col-md-2">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(unit, index) in units">
							<td>{{ unit.mac_address }}</td>
							<td>{{ unit.unit_is_active }}</td>
							<td>{{ unit.unit_is_inuse }}</td>
							<td>{{ unit.oximeter_is_active }}</td>
							<td>{{ unit.bp_is_active }}</td>
							<td>{{ unit.thermometer_is_active }}</td>
							<td>{{ unit.oximeter_delay }}</td>
							<td>{{ unit.bp_delay }}</td>
							<td>{{ unit.thermometer_delay }}</td>
							<td>
								{{ unit.created_at | moment('LLLL')}}
								<code>
									{{ unit.created_at | moment('from')}}
								</code>
							</td>
							<td>{{ unit.updated_at }}</td>
							<td>
								<button type="button" class="btn btn-info btn-xs" v-on:click="showUnitModalComponent($event, unit)"><i class="fa fa-eye"></i> Show</button>
								<button type="button" class="btn btn-warning btn-xs" v-on:click="showEditUnitModalComponent($event, unit)"> Edit</button>
								<button type="button" class="btn btn-danger btn-xs" v-on:click="showDeleteUnitModalComponent($event, unit)"> Delete</button>
								<hr />

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
				<strong>{{ unit.mac_address }}</strong>
				<p>{{ unit.unit_is_active }}</p>
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
			on_load: true,
			showCreateUnitModal: false,
			showEditUnitModal: false,
			showDeleteUnitModal: false,
			showUnitModal: false,
			unit: null,
			searchTerm: ''
		}
	},
	mounted() {
		this.$nextTick(()=>{
			this.getUnits().then((response)=>{
				this.on_load = false
			})
		})
	},
	computed: {
		loading() {
			return this.$store.getters.loading
		},
		units() {
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
			return this.$store.dispatch('getUnits', { 'search': this.searchTerm })
		}
	},
}
</script>