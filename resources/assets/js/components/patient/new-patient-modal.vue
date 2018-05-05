<template>
    <modal v-model="showModal" v-on:hide="$emit('close')" title="NewPatient" :footer="false" size="lg">
    <form ref="vForm" v-on:submit.prevent="postNewPatient($event)">
        <template v-if="isBusy">
            <img class="animated-box img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
        </template>
        <template v-else>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-error': !patient.first_name}">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="..." v-model="patient.first_name"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-error': !patient.middle_name}">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" placeholder="..." v-model="patient.middle_name"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-error': !patient.last_name}">
                                <label>Surname</label>
                                <input type="text" class="form-control" placeholder="..." v-model="patient.last_name"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group " :class="{'has-error': !patient.contact_number}">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" placeholder="..." v-model="patient.contact_number"/>
                    </div>
                    <div class="form-group " :class="{'has-error': !patient.home_address}">
                        <label>Home Address</label>
                        <input type="text" class="form-control" placeholder="..." v-model="patient.home_address"/>
                    </div>
                    <div class="form-group " :class="{'has-error': !patient.contact_person}">
                        <label>Contact Person</label>
                        <input type="text" class="form-control" placeholder="..." v-model="patient.contact_person"/>
                    </div>
                    <div class="form-group " :class="{'has-error': !patient.gender}">
                        <label >gender</label>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="patient[gender]" value="Male" v-model="patient.gender"> Male</label>
                            <label class="radio-inline"><input type="radio" name="patient[gender]" value="Female" v-model="patient.gender"> Female</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-error': !patient.location_id || hasError('patient.location_id')}">
                        <label for="location_id">Location</label>
                        <select class="form-control" id="location_id" v-model="patient.location_id" placeholder="...">
                            <option disabled selected value> -- select an option -- </option>
                            <option v-for="(location, locationsOptionIdx) in locationsOption" :key="locationsOptionIdx" :value="location.value">{{location.label}}</option>
                        </select>
                        <template v-if="hasError('patient.location_id')">
                            <p class="small text-red" v-for="(line, errorIdx) in errors['patient.location_id']" :key="errorIdx">{{line}}</p>
                        </template>
                    </div>
                    <div class="form-group" :class="{'has-error': !patient.unit_id || hasError('patient.unit_id')}">
                        <label for="unit_id">Unit</label>
                        <select class="form-control" id="unit_id" v-model="patient.unit_id" placeholder="...">
                            <option disabled selected value> -- select an option -- </option>
                            <option v-for="(unit, unitsOptionIdx) in unitsOption" :key="unitsOptionIdx" :value="unit.value">{{unit.label}}</option>
                        </select>
                        <template v-if="hasError('patient.unit_id')">
                            <p class="small text-red" v-for="(line, errorIdx) in errors['patient.unit_id']" :key="errorIdx">{{line}}</p>
                        </template>
                    </div>
                    <div class="form-group" :class="{'has-error': !patient.comment}">
                        <label>Comment</label>
                        <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="patient.comment"></textarea>
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
const blankPatientData = () => {
    return {
        'unit_id': 1,
        'location_id': 1,
        'first_name': 'Jane',
        'middle_name': 'Da',
        'last_name': 'Moe',
        'gender': 'Male',
        'age': '18',
        'home_address': 'that door close to 0001',
        'contact_number': '1112222333',
        'contact_person': 'Ma Me',
        'comment': '...',
        'is_active': false,
        'is_archive': false
    }
}
export default {
    name: 'new-patient-modal',
    data() {
        return {
            showModal: true,
            isBusy: false,
            patient: blankPatientData(),
            errors: null,
            units: null,
            locations: null
        }
    },
    created() {
        this.getUnits()
        this.getLocations()
    },
    computed: {
        locationsOption() {
             if(Boolean(this.locations))
            {
                return this.locations.data.map(location => { return {label: location.name, value: location.id} } )
            }
            return []
        },
        unitsOption() {
            if(Boolean(this.units))
            {
                return this.units.data.map(unit => { return {label: unit.label, value: unit.id} } )
            }
            return []
        },
        canPost(){
            let result = true
            Object.entries(this.patient).forEach(([attrIdx, attr])=>{
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
         async getLocations() {
            const axiosOptions = {
                'url': '/location/locations',
                'method': 'get'
            }
            await axios(axiosOptions).then(response => {
                this.locations = response.data
            }).catch(error => {
                this.locations = null
                return Promise.reject(error.response);
            })
        },
        async getUnits() {
            const axiosOptions = {
                'url': '/unit/units',
                'method': 'get',
                'params':{
                    'unit_is_inuse': 0
                } 

            }

            await axios(axiosOptions).then(response => {
                this.units = response.data
            }).catch(error => {
                this.units = null
                return Promise.reject(error.response);
            })
        },
        async postNewPatient(event){
            const axiosOptions = {
                'url': '/patient/patients',
                'method': 'post',
                'data': {patient: this.patient}
            }
            this.errors = null
            this.isBusy = true
            this.result = {}
            this.message = {}
            return await axios(axiosOptions).then( response => {
                this.patient = blankPatientData()
                this.$toaster.success(response.data.msg)
                this.$emit('patient-created')
                this.isBusy = false
                this.showModal = false
            }).catch(error => {
                this.errors = error.response.data.errors
                this.$toaster.error(error.response.data.message)
                this.isBusy = false
                return Promise.reject(error.response);
            })
            this.isBusy = false
        }
    }
}
</script>