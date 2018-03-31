<template id="patient-list">
  <div class="row">
      <!--
  <heart-beat v-if="on_load"></heart-beat>
    -->
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <div class="form-group">
              <a href="javascript:;" class="btn btn-xs btn-primary" v-on:click="showCreatePatientModalComponent($event)"><span class="glyphicon glyphicon-plus"></span>
              Add new Patient</a>
            </div>
          </div>
          <form v-on:submit.prevent="getPatients($event)">
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
                  <th>Name</th>
                  <th>location</th>
                  <th>Date Created</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(patient, index) in patients" >
                  <td v-on:click="showPatientModalComponent($event, patient)">{{ patient.last_name }}, {{ patient.first_name }} {{ patient.middle_name }}</td>
                  <td  v-on:click="showPatientModalComponent($event, patient)"><span v-if="patient.location">{{ patient.location.name }}</span></td>
                  <td  v-on:click="showPatientModalComponent($event, patient)">{{ patient.created_at | moment('LLLL')}} <code>{{ patient.created_at | moment('from')}}</code></td>
                  <td class="row">
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showPatientModalComponent($event, patient)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="patients.total === 0">
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
        <new-patient-modal ref="showCreatePatientModal" v-if="showCreatePatientModal" v-on:close="showCreatePatientModal = false" v-on:patient-created="patientCreated" ></new-patient-modal>
        
        <edit-patient-modal v-if="showEditPatientModal" v-on:close="showEditPatientModal = false" :edit-patient="patient" v-on:patient-updated="getPatients"></edit-patient-modal>

        <delete-patient-modal ref="showDeletePatientModal" :delete-patient="patient" v-if="showDeletePatientModal" v-on:patient-deleted="getPatients" v-on:close="showDeletePatientModal = false"  v-on:deleted="showPatientModal = false" ></delete-patient-modal>
        <!--show modal-->
        <modal ref="showPatientModal" v-if="showPatientModal" v-model="showPatientModal"  auto-focus v-on:hide="$emit('close')" size="lg">
          <div slot="title" >
            <div class="box-profile row">

              <h3 class="profile-patientname text-center"> {{ patient.last_name }}, {{ patient.first_name }} {{ patient.middle_name }}</h3>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <strong><i class="fa fa-map margin-r-5"></i> Location</strong>
                <p class="text-muted"><span v-if="patient.location">{{ patient.location.name }}</span></p>
                <hr>
                <strong><i class="fa fa-mobile-phone margin-r-5"></i> Contact Number</strong>
                <p class="text-muted">{{ patient.contact_number }}</p>
                <hr>
                <strong><i class="fa fa-map-o margin-r-5"></i> home Address</strong>
                <p class="text-muted">{{ patient.home_address }}</p>
                <hr>
                <strong><i class="fa fa-user margin-r-5"></i> Contact Person</strong>
                <p class="text-muted">{{ patient.contact_person }}</p>
                <hr>
                <strong><i class="fa fa-user margin-r-5"></i> gender</strong>
                <p class="text-muted">{{ patient.gender }}</p>
              </div>
              <div class="col-md-6">
                <strong><i class="fa fa-circle margin-r-5"></i> Unit</strong>
                <p class="text-muted"><span v-if="patient.unit">{{ patient.unit.mac_address }}</span></p>
                <hr>
                <strong><i class="fa fa-file-circle-o margin-r-5"></i> age</strong>
                <p>{{ patient.age }}</p>
                <hr>
                <strong><i class="fa  fa-patient-plus margin-r-5"></i>Account Created Since</strong>
                <div class="text-muted">{{patient.created_at | moment('LLLL')}}</div>
                <code>{{patient.created_at | moment('from')}}</code>
                <hr>
                <strong><i class="fa fa-calendar-check-o margin-r-5"></i>Date Updated </strong>
                <div class="text-muted">{{patient.updated_at | moment('LLLL')}}</div>
                <code>{{patient.updated_at | moment('from')}}</code>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Comment</strong>
                <p>{{ patient.comment }}</p>
              </div>
            </div>

          </div>
          <div slot="footer">
            <btn type="warning"  class="" v-on:click="showEditPatientModalComponent($event, patient)"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</btn>
            <btn type="danger"  class="" v-on:click="showDeletePatientModalComponent($event, patient)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</btn>
            <btn  v-on:click="showPatientModal=false" data-action="auto-focus">Cancel</btn>
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
      patient: null,
      showCreatePatientModal: false,
      showEditPatientModal: false,
      showDeletePatientModal: false,
      showPatientModal: false,
      searchTerm: '',
      totalPage: 18,
      currentPage: 1
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.getPatients().then((response)=>{
        this.on_load = false
      })
    })
  },
  computed: {
    loading() {
      return this.$store.getters.loading
    },
    patients() {
      return this.$store.getters.patients
    },
    filteredPatients: function(){
      if(this.patients.length) {
        return this.patients;
      }
    }
  },
  methods: {
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    patientCreated() {
      this.getPatients()
    },
    showCreatePatientModalComponent(event) {
      this.showCreatePatientModal = true
    },
    showEditPatientModalComponent(event, patient) {
      this.patient = patient
      this.$nextTick(() => {
        this.showEditPatientModal = true
      })
    },
    showDeletePatientModalComponent(event, patient) {
      this.patient = patient
      this.$nextTick(() => {
        this.showDeletePatientModal = true
      })
    },
    showPatientModalComponent(event, patient) {
      this.patient = patient
      this.$nextTick(() => {
        this.showPatientModal = true
      })
    },
    getPatients(event) {
      if(this.patient){   
      this.patient = event.patient
      }

      return this.$store.dispatch('getPatients', { 'search': this.searchTerm })
    }
  },
}
</script>
