<template>

	<div >

		<div class="card mt-3">
			<div class="card-body">

				<div class="d-flex">
					<h4>Events </h4>

					<div class="ml-3">
						<label class="btn btn-link btn-file" v-show="!form.importFile">
							<span>Import From File</span>
							<input type="file" @change="onFileChange" name="importFile" id="importFile" style="display: none">
						</label>
						<label v-show="form.importFile">
							<button class="btn btn-sm btn-outline-primary" @click="upload()">Upload</button>
							<button class="btn btn-sm btn-outline-secondary" @click="removeFile">
								Remove
							</button>
						</label>
						<label class="col-form-label">
							<small>(Allowed file types: XLS,CSV)</small>
						</label>

					</div>
				</div>
				<div class="alert alert-danger mt-1"
					 v-if="eventService.apiService.errors.has('file')"
					 v-text="eventService.apiService.errors.get('file')"></div>

				<div class="mt-2">
					<div id="accordion" role="tablist" aria-multiselectable="true">
						<div class="card">
							<div class="card-header" role="tab" id="headingAddEvent">
								<h5 class="mb-0">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseAddEvent" aria-expanded="true" aria-controls="collapseAddEvent">
										Add Event
									</a>
								</h5>
							</div>

							<div id="collapseAddEvent" class="collapse" role="tabpanel" aria-labelledby="headingAddEvent">
								<div class="card-body">
									<add-event :wedding-id="weddingId"></add-event>
								</div>
							</div>
						</div>
					</div>


				</div>

				<table class="table mt-3" id="myEvents">
					<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Event Name</th>
						<th scope="col">Description</th>
						<th scope="col">Date</th>
						<th scope="col">Actions</th>
					</tr>
					</thead>
					<tbody>
					<tr v-if="events.length > 0" v-for="event in events">
						<th scope="row" ></th>
						<td>
							<div v-if="editEventId !== event._id">{{ event.name }}</div>
							<div v-if="editEventId === event._id">
								<input type="text" id="name" name="name" placeholder="Event Name" class="input input-inline form-control" v-model="form.name" required>

								<span class="note note-danger"
									  v-if="eventService.apiService.errors.has('name')"
									  v-text="eventService.apiService.errors.get('name')"></span>
							</div>
						</td>
						<td>
							<div v-if="editEventId !== event._id">{{ event.description }}</div>
							<div v-if="editEventId === event._id">
								<input type="text" id="description" name="description" placeholder="Event Description" class="input input-inline form-control" v-model="form.description" required>

								<span class="note note-danger"
									  v-if="eventService.apiService.errors.has('description')"
									  v-text="eventService.apiService.errors.get('description')"></span>
							</div>
						</td>
						<td>
							<div v-if="editEventId !== event._id">{{ event.date | dateFormat }}</div>
							<div v-if="editEventId === event._id">
								<input type="date" id="date" name="date" class="input input-inline form-control" v-model="form.date">

								<span class="note note-danger"
									  v-if="eventService.apiService.errors.has('date')"
									  v-text="eventService.apiService.errors.get('date')"></span>
							</div>
						</td>
						<td>
							<!-- Single button -->
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action <span class="caret"></span>
								</button>
								<div class="dropdown-menu">
									<a href="javascript:;" class="dropdown-item" @click="edit(event)" v-if="editEventId !== event._id">Edit</a>
									<a href="javascript:;" class="dropdown-item" @click="remove(event._id)" v-if="editEventId !== event._id">Delete</a>
									<a href="javascript:;" class="dropdown-item" @click="cancel()" v-if="editEventId === event._id">Cancel</a>
									<a href="javascript:;" class="dropdown-item" @click="save(event._id)" v-if="editEventId === event._id">Save</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"></th>
						<td>Wedding Day !</td>
						<td>{{ wedding.brideName }} & {{ wedding.groomName }} wedding day</td>
						<td>{{ wedding.date | dateFormat }}</td>
						<td></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>


</template>

<script>
	import Form from '../../utilities/form';
	import EventService from '../../services/EventService';
	import WeddingService from '../../services/WeddingService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['weddingId'],

		data() {
			return {
				events : [],
				eventService : new EventService,
				editEventId : null,
				form : {},
				wedding: {}
			};
		},

		mounted() {
			(new WeddingService).find(this.weddingId).then(data => this.wedding = data.wedding);
			this.loadEvents();
			this.eventBusOn('trigger:reload-events', this.loadEvents);
		},

		methods: {
			loadEvents() {
				this.eventService.byWedding(this.weddingId).then(data => this.events = data.events);
			},
			remove(id) {
				this.eventService.remove(id).then(data => {
					this.triggerSimplert({
						title: 'Delete Event',
						message: 'Event has been deleted',
						type: 'success',
						onClose: this.onClose
					});
					this.eventBusEmit('trigger:reload-events', {});
				})
			},

			edit(event) {
				this.editEventId = event._id;
				this.form = new Form({
					name: event.name,
					description: event.description,
					date:  moment(event.date).format("YYYY-MM-DD")
				});
			},

			save(id) {
				this.eventService.update(id, this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Update Event',
						message: 'Event has been updated',
						type: 'success',
						onClose: this.onClose
					});
                    this.cancel();
				})
			},

			cancel() {
				this.editEventId = null;
				this.form = {};
                this.eventService.apiService.errors.clear();
			},

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.assignFile(files[0]);
            },

            assignFile(file) {
                this.form = new Form({
                    importFile: file
                })
            },

            removeFile(e) {
                this.cancel();
            },

            upload() {

                let data = new FormData();
                data.append('importFile', this.form.importFile);

                this.eventService.upload(this.weddingId, data).then(data => {
                    this.triggerSimplert({
                        title: 'Uploaded Events',
                        message: '',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-events', {});
                    this.cancel();
                });
            }

		}
	}
</script>