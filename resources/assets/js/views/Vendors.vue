<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h4>Vendors</h4>
                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Add Vendor
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="card-body">
                                        <add-vendor></add-vendor>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--VENDORS-->
                        <div v-show="vendors.length > 0">
                            <div class="mt-3" v-bind:class="vendors.length > 0 ? '' : 'show'">
                                <div class="list-group" >
                                    <a v-for="vendor in vendors"
                                       href="javascript:void(0)"
                                       class="list-group-item list-group-item-action flex-column align-items-start" >
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="fa fa-plus"></i>
                                                {{ vendor.name }}
                                                <a href="mailto:'+vendor.email'">{{ vendor.email }}</a> </h6>
                                            <div>
                                                <p>{{ vendor.cost | currencyFormat }} NIS</p>

                                            </div>

                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1">{{ vendor.phone }}</p>
                                            <button type="button" class="btn btn-sm btn-danger" @click="remove(vendor)">Delete</button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--END VENDORS-->

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
	import VendorService from '../services/VendorService';
	import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
			return {
				vendors: [],
			};
		},

		mounted() {
			this.loadVendors();
			this.eventBusOn('trigger:reload-vendors', this.loadVendors);
		},

		methods : {
			loadVendors() {
				(new VendorService()).all().then(data => this.vendors = data.vendors);
            },
            remove(vendor) {
                (new VendorService()).remove(vendor._id).then(data => {
                    this.triggerSimplert({
                        title: 'Vendor has been removed',
                        message: '',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-vendors', {});
                })
            }
        }
	}
</script>

