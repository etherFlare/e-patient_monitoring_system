<template>
    <section>
        <div class="form-group">
            <div class="text-right form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="..." v-model="patientsProviderConfig.search"  v-on:keyup.enter="patientsProvider()" v-on:focus="$event.target.select()">
                        <div class="input-group-btn">
                            <button class="btn btn-default" v-on:click="patientsProvider()"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="responsive-table">
            <table class="table">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>location</td>
                        <td>name</td>
                        <td>gender</td>
                        <td>contact</td>
                        <td>created_at</td>
                        <td>updated_at</td>
                        <td>...</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(patient, patientIdx) in payload.data" :key="patientIdx">
                        <td class="text-right">{{patient.id}}</td>
                        <td>{{patient.location.name}}</td>
                        <td>{{patient.first_name}}</td>
                        <td>{{patient.gender}}</td>
                        <td>{{patient.contact_person}}</td>
                        <td class="text-right">{{patient.created_at}}</td>
                        <td class="text-right">{{patient.updated_at}}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-warning" v-on:click="toggleSelect($event, patient)" v-if="!isSelected(patient.id)"><i class="fa fa-fw fa-square-o"></i></button> 
                            <button type="button" class="btn btn-primary" v-on:click="toggleSelect($event, patient)" v-if="isSelected(patient.id)"><i class="fa fa-fw fa-check-square-o"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="isBusy">
            <div class="fa fa-4x fa-spin fa-refresh"></div>
        </div>
        <div class="pull-right">
            <select class="form-control" v-model="patientsProviderConfig.per_page" v-on:change="patientsProvider()">
                <option v-for="(n, nIdx) in [5,10,100]">{{n}}</option>
                <option value disabled selected>-- ! --</option>
            </select>
        </div>
        <pagination v-if="payload.total" v-on:change="page=>patientsProvider({page})" v-model="payload.current_page" :total-page="payload.last_page" align="center" :max-size="3"/>
            <div class="clearfix"> </div>
        </section>
    </template>
    <script>
    import _ from 'lodash'
    const defaultPayload = () => {
        return {
            "current_page": 1,
            "data": [],
            "from": 1,
            "last_page": 1,
            "per_page": 10,
            "to": 0,
            "total": 0
        }
    }
    export default {
        name: 'Patients',
        props: {
            patients: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                payload: defaultPayload(),
                patientsProviderConfig: {
                    per_page: 5,
                    search: ''
                },
                isBusy: false
            }
        },
        mounted() {
            this.patientsProvider()
        },
        methods: {
            isSelected(patient_id) {
                const idx = _.findIndex(this.patients, patient => patient.id === patient_id );
                return idx !== -1
            },
            toggleSelect(event, patient) {
                if(this.isSelected(patient.id))
                {
                    this.$emit('remove-patient', patient.id)
                }
                else
                {
                    this.$emit('add-patient', patient.id)
                }  
            }, 
            patientsProvider(params) {
                params = params || {}
                let payload = Object.assign({}, this.payload, {data: []})
                params = Object.assign({}, payload, this.patientsProviderConfig, params)
                this.isBusy = true
                this.payload = defaultPayload()
                const axiosOptions = {
                    'url': '/patient/patients',
                    'method': 'get',
                    'params': params
                }
                axios(axiosOptions)
                .then((response) => {
                    this.payload = response.data
                    this.isBusy = false
                })
                .catch((error) => {
                    this.isBusy = false
                })
            }
        }
    }
    </script>
