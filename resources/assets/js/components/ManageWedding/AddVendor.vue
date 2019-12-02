<template>

	<div >
		<form @submit.prevent="onSubmit"
			  @keydown="vendorService.apiService.errors.clear($event.target.name)">

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
					<button class="btn btn-primary" :disabled="vendorService.apiService.errors.any()">Add Vendor</button>
				</div>
			</div>
		</form>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import VendorService from '../../services/VendorService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props : ['weddingId'],

		data() {
			return {
				form : new Form({
					name: '',
					phone: '',
					email: '',
					cost: 0,
					weddingId: this.weddingId,
				}),
				vendorService : new VendorService()
			};
		},

		mounted() {

		},

		methods: {
			onSubmit() {
				this.vendorService.add(this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Add Vendor',
						message: 'New vendor has been added',
						type: 'success',
						onClose: this.onClose
					});
					this.clearForm();
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
			}
		}
	}
</script>

