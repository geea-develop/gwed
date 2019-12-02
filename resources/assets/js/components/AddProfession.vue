<template>

		<div>
			<div class="card-title">Add New Profession</div>

			<div class="card-body">
				<form @submit.prevent="onSubmit"
					  @keydown="professionService.apiService.errors.clear($event.target.name)">

					<div class="form-group row">
						<label for="name" class="control-label"> Profession Name</label>

						<input type="text" id="name" name="name" placeholder="Profession Name" class="input input-inline form-control" v-model="form.name" required>

						<span class="note note-danger"
							  v-if="professionService.apiService.errors.has('name')"
							  v-text="professionService.apiService.errors.get('name')"></span>
					</div>

					<div class="form-group row">
						<label for="uname" class="control-label"> Profession Unique Name</label>

						<input type="text" id="uname" name="uname" placeholder="Profession Unique Name" class="input input-inline form-control" v-model="form.uname" required>

						<span class="note note-danger"
							  v-if="professionService.apiService.errors.has('uname')"
							  v-text="professionService.apiService.errors.get('uname')"></span>
					</div>

					<div class="form-group row">
						<label for="description" class="control-label"> Description</label>
						<textarea id="description" name="description" placeholder="Description" class="input input-inline form-control" v-model="form.description"></textarea>

						<span class="note note-danger"
							  v-if="professionService.apiService.errors.has('email')"
							  v-text="professionService.apiService.errors.get('email')"></span>
					</div>

					<div class="form-group row">
						<button class="btn btn-primary" :disabled="professionService.apiService.errors.any()">Add Profession</button>
					</div>
				</form>
			</div>
		</div>

</template>

<script>
	import Form from '../utilities/form';
	import ProfessionService from '../services/ProfessionService';
	import BaseComponent from './BaseComponent';

	export default {

		extends: BaseComponent,

		data() {
			return {
				form: new Form({
					name: '',
					uname: '',
					description: ''
				}),
				professionService: new ProfessionService()
			};
		},

		mounted() {

		},

		methods: {
			onSubmit() {
				this.professionService.add(this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Add Profession',
						message: 'New Profession has been added',
						type: 'success',
						onClose: this.onClose
					});
					this.clearForm();
					this.eventBusEmit('trigger:reload-professions', {});
				});
			},
			clearForm() {
				this.form = new Form({
					name: '',
					uname: '',
					description: ''
				})
			}
		}
	}
</script>

