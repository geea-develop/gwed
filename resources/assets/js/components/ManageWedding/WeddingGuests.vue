<template>

	<div class="card mt-3">

		<div class="card-body">
			<div class="d-flex">
				<h4>Guests ({{ guests.length }}/{{ wedding.guests }})</h4>


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
				  v-if="guestService.apiService.errors.has('file')"
				  v-text="guestService.apiService.errors.get('file')"></div>

			<div class="mt-2">
				<div id="accordion" role="tablist" aria-multiselectable="true">
					<div class="card">
						<div class="card-header" role="tab" id="addGuestHeading">
							<h5 class="mb-0">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseAddGuest" aria-expanded="true" aria-controls="collapseAddGuest">
									Add Guest
								</a>
							</h5>
						</div>

						<div id="collapseAddGuest" class="collapse" role="tabpanel" aria-labelledby="addGuestHeading">
							<div class="card-body">
								<add-guest :wedding-id="weddingId"></add-guest>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div>

				<table class="table mt-3" v-if="guests.length > 0" id="myGuests">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Phone no.</th>
							<th scope="col">Email Address</th>
							<th scope="col">Group</th>
							<th scope="col">Side</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="guest in guests">
							<th scope="row" ></th>
							<td>
								<div v-if="editGuestId !== guest.guest._id">
									<input type="text" class="input input-inline form-control form-control-plaintext" v-bind:value="guest.guest.name" readonly>
								</div>
								<div v-show="editGuestId === guest.guest._id">
									<input type="text" id="name" name="name" placeholder="Guest Name" class="input input-inline form-control" v-model="form.name" required>

									<span class="note note-danger"
										  v-if="guestService.apiService.errors.has('name')"
										  v-text="guestService.apiService.errors.get('name')"></span>
								</div>
							</td>
							<td>
								<div v-if="editGuestId !== guest.guest._id">
									<input type="tel" class="input input-inline form-control form-control-plaintext" v-bind:value="guest.guest.phone" readonly>
								</div>
								<div v-show="editGuestId === guest.guest._id">
									<input type="tel" id="phone" name="phone" placeholder="Guest Phone" class="input input-inline form-control" v-model="form.phone" required>

									<span class="note note-danger"
										  v-if="guestService.apiService.errors.has('phone')"
										  v-text="guestService.apiService.errors.get('phone')"></span>
								</div>
							</td>
							<td>
								<div v-if="editGuestId !== guest.guest._id">
									<input type="email" class="input input-inline form-control form-control-plaintext" v-bind:value="guest.guest.email" readonly>

								</div>
								<div v-show="editGuestId === guest.guest._id">
									<input type="email" id="email" name="email" placeholder="example@example.com" class="input input-inline form-control" v-model="form.email">

									<span class="note note-danger"
										  v-if="guestService.apiService.errors.has('email')"
										  v-text="guestService.apiService.errors.get('email')"></span>
								</div>
							</td>
							<td>
								<div class="dropdown" v-show="editGuestId === guest.guest._id">
									<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownTypeButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Select
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownTypeButton">

										<div class="col-md-12">
											<div class="btn-group-vertical btn-group-toggle" data-toggle="buttons">
												<label class="btn btn-primary" v-bind:class="form.type === 'family' ? 'active' :''" @click="toggleType('family')">
													<input type="radio" name="type" autocomplete="off" id="family" value="family"> Family
												</label>
												<label class="btn btn-primary" v-bind:class="form.type === 'work' ? 'active' :''" @click="toggleType('work')">
													<input type="radio" name="type" autocomplete="off" id="work" value="work"> Work
												</label>
												<label class="btn btn-primary" v-bind:class="form.type === 'friend' ? 'active' :''" @click="toggleType('friend')">
													<input type="radio" name="type" autocomplete="off" id="friend" value="friend"> Friend
												</label>
												<label class="btn btn-primary" v-bind:class="form.type === 'other' ? 'active' :''" @click="toggleType('other')">
													<input type="radio" name="type" autocomplete="off" id="other" value="other"> Other
												</label>
											</div>
											<!--<span class="hidden">Guest Type: {{ form.type }}</span>-->

											<span class="note note-danger"
												  v-if="guestService.apiService.errors.has('type')"
												  v-text="guestService.apiService.errors.get('type')"></span>

										</div>
									</div>
								</div>

								<div v-show="editGuestId !== guest.guest._id">
								{{guest.guest.type ? guest.guest.type : '-'}}</div>
							</td>
							<td>
								<div class="dropdown" v-show="editGuestId === guest.guest._id">
									<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSideButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Select
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownSideButton">
										<div class="col-md-12">

											<div class="btn-group-vertical btn-group-toggle" data-toggle="buttons">
												<label class="btn btn-primary" v-bind:class="form.side === 'bride' ? 'active' :''" @click="toggleSide('bride')">
													<input type="radio" name="side" autocomplete="off" id="bride" value="bride" > Bride
												</label>
												<label class="btn btn-primary" v-bind:class="form.side === 'groom' ? 'active' :''" @click="toggleSide('groom')">
													<input type="radio" name="side" autocomplete="off" id="groom" value="groom" > Groom
												</label>
											</div>
											<!--<span class="hidden">Guest Side: {{ form.side }}</span>-->

											<span class="note note-danger"
												  v-if="guestService.apiService.errors.has('side')"
												  v-text="guestService.apiService.errors.get('side')"></span>
										</div>
									</div>
								</div>
								<div v-show="editGuestId !== guest.guest._id">
									{{guest.guest.side ?guest.guest.side : '-'}} </div>
							</td>
							<td>
								<!-- Single button -->
								<div class="btn-group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Action <span class="caret"></span>
									</button>
									<div class="dropdown-menu">
										<a href="javascript:;" class="dropdown-item" @click="edit(guest.guest)" v-if="editGuestId !== guest.guest._id">Edit</a>
										<a href="javascript:;" class="dropdown-item" @click="remove(guest.guest._id)" v-if="editGuestId !== guest.guest._id">Delete</a>
										<a href="javascript:;" class="dropdown-item" @click="cancel()" v-if="editGuestId === guest.guest._id">Cancel</a>
										<a href="javascript:;" class="dropdown-item" @click="save(guest.guest._id)" v-if="editGuestId === guest.guest._id">Save</a>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import GuestService from '../../services/GuestService';
	import BaseComponent from '../BaseComponent';
    import WeddingService from "../../services/WeddingService";

	export default {

		extends: BaseComponent,

		props: ['weddingId'],

		data() {
			return {
				guests : [],
                wedding: {},
				guestService : new GuestService,
				editGuestId : null,
				form : {},
                uploadedFile: null,
                weddingService : new WeddingService
			};
		},

		mounted() {
			this.loadGuests();
            this.weddingService.find(this.weddingId).then(data => this.wedding = data.wedding);
			this.eventBusOn('trigger:reload-guests', this.loadGuests);
		},

		methods: {
			loadGuests() {
				this.guestService.byWedding(this.weddingId).then(data => this.guests = data.guests);
			},
			remove(id) {
				this.guestService.remove(id).then(data => {
					this.triggerSimplert({
						title: 'Remove Guest',
						message: 'Guest has been removed',
						type: 'success',
						onClose: this.onClose
					});
					this.eventBusEmit('trigger:reload-guests', {});
                    this.cancel();
				})
			},

			edit(guest) {
				this.editGuestId = guest._id;
				this.form = new Form({
					name: guest.name,
					phone: guest.phone,
					email: guest.email,
					type: guest.type,
					side: guest.side
				});
			},

			save(id) {
				this.guestService.update(id, this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Update Guest',
						message: 'Guest has been updated',
						type: 'success',
						onClose: this.onClose
					});
                    this.eventBusEmit('trigger:reload-guests', {});
                    this.cancel();
				})
			},

            toggleSide(side) {
			  this.form.side = side;
			},

            toggleType(type) {
                this.form.type = type;
            },

			cancel() {
				this.editGuestId = null;
                $("#importFile").val('');
				this.form = {};
				this.guestService.apiService.errors.clear();
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

			    this.guestService.upload(this.weddingId, data).then(data => {
                    this.triggerSimplert({
                        title: 'Uploaded Guests',
                        message: '',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-guests', {});
                    this.cancel();
				});
			}
		}
	}
</script>