<template>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">

					<div class="mt-3">

						<form @submit.prevent="onSubmit"
							  @keydown="eventService.apiService.errors.clear($event.target.name)">

							<div class="form-group row">
								<label for="name" class="col-md-4 col-form-label"> Event Name</label>

								<div class="col-md-8">
									<input type="text" id="name" name="name" placeholder="Event Name" class="input input-inline form-control" v-model="form.name" required>

									<span class="note note-danger"
										  v-if="eventService.apiService.errors.has('name')"
										  v-text="eventService.apiService.errors.get('name')"></span>
								</div>

							</div>

							<div class="form-group row">
								<label for="description" class="col-md-4 col-form-label"> Event Description</label>

								<div class="col-md-8">
									<input type="text" id="description" name="description" placeholder="Event Description" class="input input-inline form-control" v-model="form.description" >

									<span class="note note-danger"
										  v-if="eventService.apiService.errors.has('phone')"
									  	v-text="eventService.apiService.errors.get('phone')"></span>
								</div>
							</div>

							<div class="form-group row">
								<label for="date" class="col-md-4 col-form-label"> Date</label>

								<div class="col-md-8">
									<input type="date" id="date" name="date" class="input input-inline form-control" v-model="form.date">

									<span class="note note-danger"
										  v-if="eventService.apiService.errors.has('date')"
										  v-text="eventService.apiService.errors.get('date')"></span>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-primary btn-block" :disabled="eventService.apiService.errors.any()">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import EventService from '../../services/EventService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props : ['weddingId'],

		data() {
			return {
				form : new Form({
					name: '',
					description: '',
					date: null,
					weddingId: this.weddingId,
				}),
				eventService : new EventService()
			};
		},

		mounted() {

		},

		methods: {
			onSubmit() {
				this.eventService.add(this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Event created',
						message: 'New event added to schedule',
						type: 'success',
						onClose: this.onClose
					});
					this.clearForm();
					this.eventBusEmit('trigger:reload-events', {});
				});
			},
			clearForm() {
				this.form = new Form({
					name: '',
					description: '',
					date: null,
					weddingId: this.weddingId,
				});
			},
		}
	}
</script>

