<template>
    <modal v-model="showModal" v-on:hide="$emit('close')" title="New Unit" :footer="false" size="lg">
        <form ref="vForm" v-on:submit.prevent="postNewUnit($event)">
            <template v-if="isBusy">
                <img class="animated-box  img-responsive img-circle " src="/img/heart-beat.png" alt="some picture" >
            </template>
            <template v-else>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fa  fa-circle-o margin-r-5"></i>Activation Status</strong></p>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="switch">
                                    <input type="checkbox" checked v-model="unit.unit_is_active"/>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group" :class="{'has-error': !unit.mac_address}">
                            <label><i class="fa fa-mobile-phone margin-r-5"></i>Mac Address</label>
                            <input type="text" class="form-control" placeholder="..." v-model="unit.mac_address" v-mask="['XX:XX:XX:XX:XX:XX']"/>
                        </div>
                        <hr>
                        <div class="form-group" >
                            <label>Comment</label>
                            <textarea cols="10" rows="5" class="form-control" placeholder="..." v-model="unit.comment"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>
                                <i class="fa  fa-circle-o margin-r-5"></i>Label
                            </strong>
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" :class="{'has-error': !unit.label}">
                                    <input type="text" class="form-control" placeholder="..." v-model="unit.label"/>
                                </div>
                            </div>
                        </div>
                        <p>
                            <strong>
                                <i class="fa  fa-circle-o margin-r-5"></i> Unit Oximeter Status
                            </strong>
                        </p>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="switch">
                                    <input type="checkbox" checked v-model="unit.oximeter_is_active"/>
                                    <span class="slider round "></span>
                                </label>
                            </div>
                            <div class="col-xs-9">
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                <input type="text" class="form-control" placeholder="..." v-model="unit.oximeter_delay"/>
                            </div>
                        </div>
                        <p>
                            <strong>
                                <i class="fa fa-circle-o margin-r-5"></i> Account Sphygmomanometer Status
                            </strong>
                        </p>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="switch">
                                    <input type="checkbox" checked v-model="unit.bp_is_active"/>
                                    <span class="slider round "></span>
                                </label>
                            </div>
                            <div class="col-xs-9">
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                <input type="text" class="form-control" placeholder="..." v-model="unit.bp_delay"/>
                            </div>
                        </div>
                        <p>
                            <strong>
                                <i class="fa  fa-circle-o margin-r-5"></i>Account Thermometer Status
                            </strong>
                        </p>
                        <div class="row">
                            <div class="col-xs-3">
                                <label class="switch">
                                    <input type="checkbox" checked v-model="unit.thermometer_is_active"/>
                                    <span class="slider round "></span>
                                </label>
                            </div>
                            <div class="col-xs-9">
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> Delay</strong>
                                <input type="text" class="form-control" placeholder="..." v-model="unit.thermometer_delay"/>
                            </div>
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
import {mask} from 'vue-the-mask'
const blankUnitData = () => {
    return {
        'mac_address': 'ff:ff:ff:ff:ff:ff',
        'label': 'samplex',
        'unit_is_active': false,
        'unit_is_inuse': false,
        'oximeter_is_active': false,
        'bp_is_active': false,
        'thermometer_is_active': false,
        'oximeter_delay': 1000,
        'bp_delay': 1000,
        'thermometer_delay': 1000,
        'comment': '...'
    }
}
export default {
    directives: { mask },
    name: 'new-unit-modal',
    data() {
        return {
            showModal: true,
            isBusy: false,
            errors: null,
            unit: blankUnitData(),
            time: new Date(''),
        }
    },
    computed: {
        canPost(){
            let result = true
            Object.entries(this.unit).forEach(([attrIdx, attr])=>{
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
        async postNewUnit(event){
            const axiosOptions = {
                'url': '/unit/units',
                'method': 'post',
                'data': {unit: this.unit}
            }
            this.errors = null
            this.isBusy = true
            this.result = {}
            this.message = {}
            return await axios(axiosOptions).then( response => {
                this.unit = blankUnitData()
                this.$toaster.success(response.data.msg)
                this.$emit('unit-created')
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