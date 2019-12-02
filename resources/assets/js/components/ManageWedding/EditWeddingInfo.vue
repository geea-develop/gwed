<template>

	<div class="row">
		<div class="col-md-6 col-md-offset-0 mt-3 ">

			<div class="card">

				<div class="card-body">

					<form @submit.prevent="update(weddingId)"
						  @keydown="weddingService.apiService.errors.clear($event.target.name)">

						<div class="form-group row">

							<label for="brideName" class="col-md-4 col-form-label"> Bride's Name</label>

							<div class="col-md-8">

								<input type="text" id="brideName" name="brideName" class="input input-inline form-control" v-model="form.brideName" required>

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('brideName')"
									  v-text="weddingService.apiService.errors.get('brideName')"></span>

							</div>

						</div>

						<div class="form-group row">

							<label for="groomName" class="col-md-4 col-form-label"> Groom's Name</label>

							<div class="col-md-8">

								<input type="text" id="groomName" name="groomName" class="input input-inline form-control" v-model="form.groomName" required>

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('groomName')"
									  v-text="weddingService.apiService.errors.get('groomName')"></span>

							</div>

						</div>

						<div class="form-group row">

							<label for="location" class="col-md-4 col-form-label"> Location</label>

							<div class="col-md-8">

								<input type="text" id="location" name="location" placeholder="Location" class="input input-inline form-control" v-model="form.location" required>

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('location')"
									  v-text="weddingService.apiService.errors.get('location')"></span>

							</div>

						</div>

						<div class="form-group row">

							<label for="date" class="col-md-4 col-form-label"> Date </label>

							<div class="col-md-8">

								<input type="date" id="date" name="date" class="input input-inline form-control" v-model="form.date" required>

								<span class="badge badge-secondary">{{form.date | dateFromNow}}</span>

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('date')"
									  v-text="weddingService.apiService.errors.get('date')"></span>
							</div>

						</div>

						<div class="form-group row">

							<label for="guests" class="col-md-4 col-form-label"> Guests</label>

							<div class="col-md-8">

								<input type="number" min="1" max="800" id="guests" name="guests" class="input input-inline form-control" v-model="form.guests" required>

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('guests')"
									  v-text="weddingService.apiService.errors.get('guests')"></span>
							</div>

						</div>

						<div class="form-group row">

							<label for="budget" class="col-md-4 col-form-label"> Budget</label>

							<div class="col-md-8">

								<input type="number" step="any" id="budget" name="budget" class="input input-inline form-control" v-model="form.budget">

								<span class="note note-danger"
									  v-if="weddingService.apiService.errors.has('budget')"
									  v-text="weddingService.apiService.errors.get('budget')"></span>
							</div>

						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<button class="btn btn-primary btn-block" :disabled="weddingService.apiService.errors.any()">Save</button>
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
	import WeddingService from '../../services/WeddingService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['weddingId'],

		data() {
			return {
				form : new Form({
					brideName: '',
					groomName: '',
					location: '',
					date: null,
					guests: 1,
					budget: 0,
				}),
				weddingService : new WeddingService
			};
		},

		mounted() {
			this.weddingService.find(this.weddingId).then(data => this.setForm(data.wedding));
		},

		methods: {
			update(id) {
				this.weddingService.update(id, this.form.data()).then(() => {
					this.triggerSimplert({
						title: 'Wedding saved',
						message: '',
						type: 'success',
						onClose: this.onClose
					});
					this.weddingService.find(id).then(data => this.setForm(data.wedding));
					this.eventBusEmit('trigger:wedding-info-updated', {});
				});
			},

			setForm(wedding) {
				this.form = new Form(
					{
						brideName: wedding.brideName,
						groomName: wedding.groomName,
						location: wedding.location,
						date: moment(wedding.date).format("YYYY-MM-DD"),
						guests: (wedding.guests) ? wedding.guests : 1,
						budget: (wedding.budget) ? wedding.budget : 0,
					}
				);
			}
		}
	}
</script>