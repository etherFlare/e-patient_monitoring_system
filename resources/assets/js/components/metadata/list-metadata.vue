<template id="metadata-list">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <form v-on:submit.prevent="getMetadatas($event)">
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
          <!-- <heart-beat v-if="on_load"></heart-beat> -->
          <div v-if="Boolean(metadatas)">
            <table  id="ex1" class="table table-bordered table-hover">
              <thead >
                <tr>
                  <th>unit_id</th>
                  <th>mac</th>
                  <th>sensor_type</th>
                  <th>sensor_value</th>
                  <th>Date Created</th>
                  <th><i class="fa fa-spin fa-refresh" v-if="on_load"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(metadata, index) in metadatas" >
                  <td v-on:click="showMetadataModalComponent($event, metadata)">{{ metadata.unit_id }}</td>
                  <td v-on:click="showMetadataModalComponent($event, metadata)">{{ metadata.mac }}</td>
                  <td v-on:click="showMetadataModalComponent($event, metadata)">{{ metadata.sensor_type }}</td>
                  <td v-on:click="showMetadataModalComponent($event, metadata)">{{ toJson(metadata.sensor_value) }}</td>
                  <td  v-on:click="showMetadataModalComponent($event, metadata)">{{ metadata.created_at | moment('LLLL')}}</code></td>
                  <td class="row">
                    <btn size="xs" type="primary" class="col-xs-12" style="margin-left:3px;margin-right:3px;" v-on:click="showMetadataModalComponent($event, metadata)"><i class="fa fa-eye"></i> Show</btn>
                  </td>
                </tr>
                <tr v-if="!metadatas.length">
                  <td colspan="6" class="text-center">
                    <p class="no-margin text-red">{{searchTerm}} was not in the list</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
          <pagination v-model="currentPage" :total-page="totalPage" align="center" :max-size="3"/>
        </div>
        <modal ref="showMetadataModal" v-if="showMetadataModal" v-model="showMetadataModal"  auto-focus v-on:hide="$emit('close')" >
          <div slot="title" >
            <div class="box-profile row">
              <img class="animated-box profile-user-img img-responsive img-circle pull-right " src="/img/heart-beat.png" alt="Metadata profile picture" style="margin-right:50px">
            </div>
          </div>
          <div class="box-body">
            <strong><i class="fa fa-circle-o margin-r-5"></i> Unit id</strong>
            <p class="text-muted">{{ metadata.unit_id }}</p>
            <hr>
            <strong><i class="fa fa-circle-o margin-r-5"></i>Mac</strong>
            <p class="text-muted">{{ metadata.mac }}</p>
            <hr>
            <strong><i class="fa fa-circle-o margin-r-5"></i> Unit id</strong>
            <p class="text-muted">{{ metadata.sensor_type }}</p>
            <hr>
            <strong><i class="fa fa-circle-o margin-r-5"></i> Unit id</strong>
            <p class="text-muted">{{ metadata.sensor_value }}</p>
            <hr>
            <strong><i class="fa  fa-metadata-plus margin-r-5"></i>logged sinceSince</strong>
            <div class="text-muted">{{metadata.created_at | moment('LLLL')}}</div>
            <code>{{metadata.created_at | moment('from')}}</code>
            <hr>
            <hr>
          </div>
          <div slot="footer">
            <btn  v-on:click="showMetadataModal=false" data-action="auto-focus">Cancel</btn>
          </div>
        </modal>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      on_load: true,
      metadata: null,
      showMetadataModal: false,
      searchTerm: '',
      totalPage: 18,
      currentPage: 1
    }
  },
  mounted() {

    setInterval(()=>{
      this.on_load = true
      this.getMetadatas().then((response)=>{
        this.on_load = false
      })
      
    }, 5000)

  },
  computed: { 
    loading() {
      return this.$store.getters.loading
    },
    metadatas() {
      return this.$store.getters.metadatas
    }, 
    filteredMetadatas: function(){
      if(this.metadatas.length) {
        return this.metadatas;
      }
    }
  },
  methods: {
    toJson(text){
      try {
        text = JSON.parse(text)
      } catch(e) {
        console.log(e)
      }
      console.log('toJson', text)
      return text
    },
    callback (msg) {
      this.$notify(`Modal dismissed with msg '${msg}'.`)
    },
    metadataCreated() {
      this.getMetadatas()
    },
    showMetadataModalComponent(event, metadata) {
      this.metadata = metadata
      this.$nextTick(() => {
        this.showMetadataModal = true
      })
    },
    getMetadatas(event) {
      return this.$store.dispatch('getMetadatas', { 'search': this.searchTerm })
    }
  }
}
</script>