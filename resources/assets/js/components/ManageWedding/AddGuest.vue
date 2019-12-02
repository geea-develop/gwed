<template>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">

					<form @submit.prevent="onSubmit"
						  @keydown="guestService.apiService.errors.clear($event.target.name)">

						<div class="form-group row">
							<!--<label for="name" class="col-md-2 col-form-label">Name</label>-->

							<div class="col-md-12">
								<input type="text" id="name" name="name" placeholder="Name" class="input input-inline form-control" v-model="form.name" required>

								<span class="note note-danger"
									  v-if="guestService.apiService.errors.has('name')"
									  v-text="guestService.apiService.errors.get('name')"></span>
							</div>

						</div>
						<div class="form-group row">
							<!--<label for="phone" class="col-md-2 col-form-label">Phone</label>-->

							<div class="col-md-12">
								<input type="tel" id="phone" name="phone" placeholder="Phone no." class="input input-inline form-control" v-model="form.phone" >

								<span class="note note-danger"
									  v-if="guestService.apiService.errors.has('phone')"
									  v-text="guestService.apiService.errors.get('phone')"></span>
							</div>

						</div>
						<div class="form-group row">

							<!--<label for="email" class="col-md-2 col-form-label"> Email</label>-->
							<div class="col-md-12">
								<input type="email" id="email" name="email" placeholder="Email Address" class="input input-inline form-control" v-model="form.email">

								<span class="note note-danger"
									  v-if="guestService.apiService.errors.has('email')"
									  v-text="guestService.apiService.errors.get('email')"></span>
							</div>

						</div>
						<div class="form-group row">

							<!--<label for="family" class="col-md-2 col-form-label">Group: </label>-->

							<div class="col-md-12">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-primary">
										<input type="radio" name="type" autocomplete="off" id="family" value="family" v-model="form.type"> Family
									</label>
									<label class="btn btn-primary">
										<input type="radio" name="type" autocomplete="off" id="work" value="work" v-model="form.type"> Work
									</label>
									<label class="btn btn-primary">
										<input type="radio" name="type" autocomplete="off" id="friend" value="friend" v-model="form.type"> Friend
									</label>
									<label class="btn btn-primary">
										<input type="radio" name="type" autocomplete="off" id="other" value="other" v-model="form.type"> Other
									</label>
								</div>
								<!--<span class="hidden">Guest Type: {{ form.type }}</span>-->

								<span class="note note-danger"
									  v-if="guestService.apiService.errors.has('type')"
									  v-text="guestService.apiService.errors.get('type')"></span>

							</div>
						</div>
						<div class="form-group row">

							<!--<label for="bride" class="col-md-2 col-form-label">Side: </label>-->

							<div class="col-md-12">

								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-primary">
										<input type="radio" name="side" autocomplete="off" id="bride" value="bride" v-model="form.side"> Bride
									</label>
									<label class="btn btn-primary">
										<input type="radio" name="side" autocomplete="off" id="groom" value="groom" v-model="form.side"> Groom
									</label>
								</div>
								<!--<span class="hidden">Guest Side: {{ form.side }}</span>-->

								<span class="note note-danger"
									  v-if="guestService.apiService.errors.has('side')"
									  v-text="guestService.apiService.errors.get('side')"></span>
							</div>
						</div>

						<div class="form-group row">

							<div class="col-md-12">
								<button class="btn btn-primary btn-block" :disabled="guestService.apiService.errors.any()">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import GuestService from '../../services/GuestService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props : ['weddingId'],

		data() {
			return {
				form : new Form({
					name: '',
					side: '',
					type: '',
					phone: '',
					email: '',
					weddingId: this.weddingId,
				}),
				guestService : new GuestService()
			};
		},

		mounted() {

		},

		methods: {
			onSubmit() {
				this.guestService.add(this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Add Guest',
						message: 'New guest has been added',
						type: 'success',
						onClose: this.onClose
					});
					this.clearForm();
					this.eventBusEmit('trigger:reload-guests', {});
				});
			},
			clearForm() {
				this.form = new Form({
					name: '',
					side: '',
					type: '',
					phone: '',
					email: '',
					weddingId: this.weddingId,
				});
			},
		}
	}
</script>

