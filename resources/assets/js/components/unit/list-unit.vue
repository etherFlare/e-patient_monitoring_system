<template id="unit-list">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
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
                </div>
                <div class="box-body">
                    <div v-if="!loading">
                        <table  id="ex1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>state</th>
                                    <th>Name</th>
                                    <th>label</th>
                                    <th class="col-md-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(unit, index) in units">
                                    <td v-on:click="showUnitModalComponent($event, unit)">
                                        <label class="switch">
                                            <input type="checkbox" disabled="disabled"  checked v-model="unit.unit_is_active">
                                            <span class="slider round "></span>
                                        </label>
                                    </td>
                                    <td v-on:click="showUnitModalComponent($event, unit)">{{ unit.mac_address }}</td>
                                    <td  v-on:click="showUnitModalComponent($event, unit)">{{ unit.label }}</td>
                                    <td class="row">
                                        <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showUnitModalComponent($event, unit)"><i class="fa fa-eye"></i> Show</btn>
                                    </td>
                                </tr>
                                <tr v-if="!units.length">
                                    <td colspan="4" class="text-center">
                                        <p> {{searchTerm}} was not in the list</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <pagination v-model="currentPage" :total-page="totalPage" align="center" :max-size="3"/>
                </div>
                <new-unit-modal ref="showCreateUnitModal" v-if="showCreateUnitModal" v-on:close="showCreateUnitModal = false" v-on:unit-created="unitCreated" ></new-unit-modal>
                <edit-unit-modal v-if="showEditUnitModal" v-on:close="showEditUnitModal = false" :edit-unit="unit" v-on:unit-updated="getUnits"></edit-unit-modal>
                <delete-unit-modal ref="showDeleteUnitModal" :delete-unit="unit" v-if="showDeleteUnitModal" v-on:unit-deleted="getUnits" v-on:close="showDeleteUnitModal = false"  v-on:deleted="showUnitModal = false" ></delete-unit-modal>
                <template v-if="showUnitModal">
                    <modal ref="showUnitModal" size="lg" v-model="showUnitModal"  auto-focus v-on:hide="$emit('close')" >
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>
                                        <i class="fa  fa-unit-plus margin-r-5"></i>Activation Status
                                    </strong>
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="switch">
                                            <input type="checkbox" disabled="disabled" checked v-model="unit.unit_is_active">
                                            <span class="slider round "></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-9">
                                        <strong><i class="fa fa-circle-o margin-r-5"></i>Label</strong>
                                        <p>{{ unit.label }}</p>
                                    </div>
                                </div>
                                <strong>Mac Address</strong>
                                <p class="text-muted">{{ unit.mac_address }}</p>
                                <hr>
                                <strong>Unit Registered Since</strong>
                                <div class="text-muted">{{unit.created_at | moment('LLLL')}}</div>
                                <code>{{unit.created_at | moment('from')}}</code>
                                <hr>
                                <strong>Unit Date Updated </strong>
                                <div class="text-muted">{{unit.updated_at | moment('LLLL')}}</div>
                                <code>{{unit.updated_at | moment('from')}}</code>
                                <hr>
                                <strong>Comment</strong>
                                <p>{{ unit.comment }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>
                                        <i class="fa  fa-unit-plus margin-r-5"></i>Usage Status
                                    </strong>
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="switch">
                                            <input type="checkbox" disabled="disabled" checked v-model="unit.unit_is_inuse">
                                            <span class="slider round "></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-9">
                                        <strong><i class="fa fa-user margin-r-5"></i>Used By</strong>
                                        <div v-for="(patient, patientsIdx) in unit.patients" :key="patientsIdx">{{ `${patient.first_name} ${patient.middle_name} ${patient.last_name} ${patient.created_at}` }}</div>
                                    </div>
                                </div>
                                <hr>
                                <p>
                                    <strong>
                                        <i class="fa  fa-unit-plus margin-r-5"></i>Oximeter Status
                                    </strong>
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="switch">
                                            <input type="checkbox"  disabled="disabled" checked v-model="unit.oximeter_is_active">
                                            <span class="slider round "></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-9">
                                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                        <p>{{ unit.oximeter_delay }}</p>
                                    </div>
                                </div>
                                <hr>
                                <p>
                                    <strong>
                                        <i class="fa  fa-unit-plus margin-r-5"></i>Sphygmomanometer Status
                                    </strong>
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="switch">
                                            <input type="checkbox" disabled="disabled"  checked v-model="unit.bp_is_active">
                                            <span class="slider round "></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-9">
                                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                        <p>{{ unit.bp_delay }}</p>
                                    </div>
                                </div>
                                <hr>
                                <p>
                                    <strong>
                                        <i class="fa  fa-unit-plus margin-r-5"></i>Thermometer Status
                                    </strong>
                                </p>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="switch">
                                            <input type="checkbox"  disabled="disabled"  checked v-model="unit.thermometer_is_active">
                                            <span class="slider round "></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-9">
                                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                        <p>{{ unit.thermometer_delay }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div slot="footer">
                            <btn type="warning"  class="" v-on:click="showEditUnitModalComponent($event, unit)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
                            <btn type="danger"  class="" v-on:click="showDeleteUnitModalComponent($event, unit)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
                            <btn  v-on:click="showUnitModal=false" data-action="auto-focus">Cancel</btn>
                        </div>
                    </modal>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            on_load: true,
            unit: null,
            showCreateUnitModal: false,
            showEditUnitModal: false,
            showDeleteUnitModal: false,
            showUnitModal: false,
            searchTerm: '',
            totalPage: 18,
            currentPage: 1
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
        callback (msg) {
            this.$notify(`Modal dismissed with msg '${msg}'.`)
        },
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
