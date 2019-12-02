<template>

	<div >

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">New Vendor</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<form @submit.prevent="onSubmit"
								  @keydown="vendorService.apiService.errors.clear($event.target.name)">

								<div class="modal-body" v-if="editVendorId === null">
									<p>Submit request to list a new vendor</p>

								<div class="form-group row">
									<label for="name" class="col-md-4 col-form-label"> Vendor Name</label>

									<div class="col-md-8">
										<input type="text" id="name" name="name" placeholder="Vendor Name" class="input input-inline form-control" v-model="form.name" required>

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('name')"
											  v-text="vendorService.apiService.errors.get('name')"></span>
									</div>
								</div>

								<div class="form-group row">
									<label for="phone" class="col-md-4 col-form-label"> Vendor Phone</label>

									<div class="col-md-8">
										<input type="tel" id="phone" name="phone" placeholder="Vendor Phone" class="input input-inline form-control" v-model="form.phone" required>

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('phone')"
											  v-text="vendorService.apiService.errors.get('phone')"></span>
									</div>
								</div>

								<div class="form-group row">
									<label for="email" class="col-md-4 col-form-label"> Email</label>

									<div class="col-md-8">
										<input type="email" id="email" name="email" placeholder="example@example.com" class="input input-inline form-control" v-model="form.email">

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('email')"
											  v-text="vendorService.apiService.errors.get('email')"></span>
									</div>
								</div>

								<div class="form-group row">
									<label for="cost" class="col-md-4 col-form-label"> Cost</label>

									<div class="col-md-8">
										<input type="number" step="any" id="cost" name="cost" class="input input-inline form-control" v-model="form.cost">

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('cost')"
											  v-text="vendorService.apiService.errors.get('cost')"></span>
									</div>

								</div>

								<div class="form-group row">
									<div class="col-md-12">

									</div>
								</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="clearForm()">Close</button>
							<button class="btn btn-primary" :disabled="vendorService.apiService.errors.any()">Add Vendor</button>
						</div>
					</form>

				</div>
			</div>
		</div>

		<div>
			<div class="card mt-3">
				<div class="card-body">
					<!--<a class="btn-link" href="#" data-toggle="collapse" data-target="#myVendors" aria-expanded="false" aria-controls="myVendors">-->
					<h4>
						My {{vendors.length === 1 ? 'Vendor' : 'Vendors'}}
					</h4>
					<!--</a>-->

					<div class="collapse show mt-3">
						<table class="table" v-if="weddingVendors.length > 0" id="myVendors">
							<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Vendor Name</th>
								<th scope="col">Phone</th>
								<th scope="col">Email</th>
								<th scope="col">Cost (NIS)</th>
								<th scope="col">Actions</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="vendor in weddingVendors">
								<th scope="row" ></th>
								<td >
									<!--name-->
									<div v-if="editVendorId !== vendor.vendor._id">{{ vendor.vendor.name }}</div>
									<div v-if="editVendorId === vendor.vendor._id">
										<input type="text" id="name" name="name" placeholder="Vendor Name" class="input input-inline form-control" v-model="form.name" required>

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('name')"
											  v-text="vendorService.apiService.errors.get('name')"></span>
									</div>
								</td>
								<td>
									<!--phone-->
									<div v-if="editVendorId !== vendor.vendor._id">{{ vendor.vendor.phone }}</div>
									<div v-if="editVendorId === vendor.vendor._id">
										<input type="tel" id="phone" name="phone" placeholder="Vendor Phone" class="input input-inline form-control" v-model="form.phone" required>

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('phone')"
											  v-text="vendorService.apiService.errors.get('phone')"></span>
									</div>
								</td>
								<td>
									<!--email-->
									<div v-if="editVendorId !== vendor.vendor._id">{{ vendor.vendor.email }}</div>
									<div v-if="editVendorId === vendor.vendor._id">
										<input type="email" id="email" name="email" placeholder="example@example.com" class="input input-inline form-control" v-model="form.email">

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('email')"
											  v-text="vendorService.apiService.errors.get('email')"></span>
									</div>
								</td>
								<td>
									<!--cost-->
									<div v-if="editVendorId !== vendor.vendor._id">{{ vendor.vendor.cost | currencyFormat}}</div>
									<div v-if="editVendorId === vendor.vendor._id">
										<input type="number" step="any" id="cost" name="cost" class="input input-inline form-control" v-model="form.cost">

										<span class="note note-danger"
											  v-if="vendorService.apiService.errors.has('cost')"
											  v-text="vendorService.apiService.errors.get('cost')"></span>
									</div>
								</td>
								<td>
									<!--actions-->
									<button type="button" class="btn btn-danger" @click="remove(vendor.vendor._id)">Remove</button>
									<!--<div class="btn-group">-->
									<!--<button type="button" class="btn btn-default dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
									<!--Action <span class="caret"></span>-->
									<!--</button>-->
									<!--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
									<!--<a href="javascript:;" class="dropdown-item" @click="edit(vendor.vendor)" v-if="editVendorId !== vendor.vendor._id">Edit</a>-->
									<!--<a href="javascript:;" class="dropdown-item" @click="remove(vendor.vendor._id)" v-if="editVendorId !== vendor.vendor._id">Delete</a>-->
									<!--<a href="javascript:;" class="dropdown-item" @click="cancel()" v-if="editVendorId === vendor.vendor._id">Cancel</a>-->
									<!--<a href="javascript:;" class="dropdown-item" @click="save(vendor.vendor._id)" v-if="editVendorId === vendor.vendor._id">Save</a>-->
									<!--</div>-->
									<!--</div>-->
								</td>
							</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">

					<!--VENDORS-->
					<div v-show="vendors.length > 0">
						<a class="btn-link" href="#" data-toggle="collapse" data-target="#attachVendor" aria-expanded="false" aria-controls="attachVendor">
							<h4>
								{{vendors.length === 1 ? 'Another Vendor' : 'More Vendors'}}
							</h4>
						</a>
						<p class="text-secondary">We offer a selective list of vendors which have been approved by our team. If you have a new vendor you would like to add please let us know so other people may enjoy their services too. <a href="#" data-toggle="modal" data-target="#exampleModal">List new vendor</a></p>
						<div class="collapse mt-3" id="attachVendor" v-bind:class="weddingVendors.length > 0 ? '' : 'show'">
							<div class="list-group" >
								<a v-for="vendor in vendors" v-bind:class="weddingVendorsArr.indexOf(vendor._id) === -1 ? '' : 'list-group-item-success'"
								   href="javascript:void(0)"
								   @click="attach(vendor)"
								   class="list-group-item list-group-item-action flex-column align-items-start" >
									<div class="d-flex w-100 justify-content-between">
										<h6 class="mb-1">
											<i class="fa fa-plus"></i>
											{{ vendor.name }}
											<a href="mailto:'+vendor.email'">{{ vendor.email }}</a> </h6>
										<small>{{ vendor.cost | currencyFormat }} NIS</small>
									</div>
									<p class="mb-1">{{ vendor.phone }}</p>
									<small></small>
								</a>
							</div>
						</div>
					</div>
					<!--END VENDORS-->

					<!--<p></p>-->
					<!--Not on list?-->
					<!--<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#addVendor" aria-expanded="false" aria-controls="addVendor">-->
						<!--Add a new vendor-->
					<!--</button>-->
					<!--<div class="collapse" id="addVendor">-->
						<!--<br />-->
						<!--<add-vendor :wedding-id="weddingId"></add-vendor>-->
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import VendorService from '../../services/VendorService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['weddingId'],

		data() {
			return {
				vendors : [],
                weddingVendors : [],
                weddingVendorsArr : [],
				vendorService : new VendorService,
				editVendorId : null,
                form : new Form({
                    name: '',
                    phone: '',
                    email: '',
                    cost: 0,
                    weddingId: this.weddingId,
                }),
			};
		},

		mounted() {
			this.loadVendors();
			this.eventBusOn('trigger:reload-vendors', this.loadVendors);
		},

		methods: {
            loadVendors() {
                this.vendorService.all().then(data => this.vendors = data.vendors);
                this.vendorService.byWedding(this.weddingId).then(data => {
                    this.weddingVendorsArr = [];
                    this.weddingVendors = data.vendors;
                    data.vendors.forEach(vendor => {
                        this.weddingVendorsArr.push(vendor.vendorId);
                    });
                });
            },

            attach(vendor) {
                if (this.weddingVendorsArr.indexOf(vendor._id) !== -1) return;
                this.vendorService.attachToWedding(vendor._id, this.weddingId).then(data => {
                    this.triggerSimplert({
                        title: 'Vendor attached',
                        message: '' + vendor.name ,
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-vendors', {});
                });
            },

			remove(id) {
				this.vendorService.detachFromWedding(id).then(data => {
					this.triggerSimplert({
						title: 'Remove Vendor',
						message: 'Vendor has been removed',
						type: 'success',
						onClose: this.onClose
					});
					this.eventBusEmit('trigger:reload-vendors', {});
				})
			},

			edit(vendor) {
				this.editVendorId = vendor._id;
				this.form = new Form({
					name: vendor.name,
					phone: vendor.phone,
					email: vendor.email,
					cost: vendor.cost
				});
			},

			save(id) {
				this.vendorService.update(id, this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Update Vendor',
						message: 'Vendor has been updated',
						type: 'success',
						onClose: this.onClose
					});
					this.cancel();
				})
			},

            onSubmit() {
                this.vendorService.add(this.form.data()).then(data => {
                    this.triggerSimplert({
                        title: 'Add Vendor',
                        message: 'New vendor has been added',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.clearForm();
                    $('#exampleModal').modal('hide');
                    this.eventBusEmit('trigger:reload-vendors', {});
                });
            },

            clearForm() {
                this.form = new Form({
                    name: '',
                    phone: '',
                    email: '',
                    cost: 0,
                    weddingId: this.weddingId,
                });
            },

			cancel() {
				this.editVendorId = null;
				this.form = {};
                this.vendorService.apiService.errors.clear();
			},

		}
	}
</script>