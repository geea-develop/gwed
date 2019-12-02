<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-0">
            <div class="card">

                <div class="card-body" v-show="showGoBack">
                    <router-link to="/" class="">Back to Dashboard</router-link>
                </div>

                <div class="card-header">
                    <span v-show="!showGoBack">Please enter some basic information about your wedding</span>
                    <a class="pull-right" href="javascript: ;" @click="hideGoBack()" v-show="showGoBack">Create Another</a>
                </div>

                <div class="card-body" v-show="!showGoBack">

                    <form @submit.prevent="onSubmit"
                          @keydown="weddingService.apiService.errors.clear($event.target.name)">

                        <div class="form-group row">
                            <label for="brideName" class="col-md-4 col-form-label"> Bride's Name*</label>

                            <div class="col-md-8">
                                <input type="text" id="brideName" name="brideName" placeholder="Bride Name" class="input input-inline form-control" v-model="form.brideName" required>
                            </div>

                            <span class="note note-danger"
                                  v-if="weddingService.apiService.errors.has('brideName')"
                                  v-text="weddingService.apiService.errors.get('brideName')"></span>
                        </div>

                        <div class="form-group row">
                            <label for="groomName" class="col-md-4 col-form-label"> Groom's Name*</label>

                            <div class="col-md-8">
                                <input type="text" id="groomName" name="groomName" placeholder="Groom Name" class="input input-inline form-control" v-model="form.groomName" required>
                            </div>

                            <span class="note note-danger"
                                  v-if="weddingService.apiService.errors.has('groomName')"
                                  v-text="weddingService.apiService.errors.get('groomName')"></span>
                        </div>

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label"> Location*</label>

                            <div class="col-md-8">
                                <input type="text" id="location" name="location" placeholder="Location" class="input input-inline form-control" v-model="form.location" required>
                            </div>

                            <span class="note note-danger"
                                  v-if="weddingService.apiService.errors.has('location')"
                                  v-text="weddingService.apiService.errors.get('location')"></span>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label"> Date*</label>

                            <div class="col-md-8">
                                <input type="date" id="date" name="date" class="input input-inline form-control" v-model="form.date" required>
                            </div>

                            <span class="note note-danger"
                                  v-if="weddingService.apiService.errors.has('date')"
                                  v-text="weddingService.apiService.errors.get('date')"></span>
                        </div>

                        <div class="form-group row">
                            <label for="guests" class="col-md-4 col-form-label"> Guests*</label>

                            <div class="col-md-8">
                                <input type="number" min="1" max="800" id="guests" name="guests" class="input input-inline form-control" v-model="form.guests" required>
                            </div>

                            <span class="note note-danger"
                                  v-if="weddingService.apiService.errors.has('guests')"
                                  v-text="weddingService.apiService.errors.get('guests')"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" :disabled="weddingService.apiService.errors.any()">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
	import Form from '../utilities/form';
	import WeddingService from '../services/WeddingService';
	import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
			return {
        form : new Form({
            brideName: '',
            groomName: '',
            location: '',
            guests: 0,
            date: null,
        }),
        showGoBack : false,
        weddingService : new WeddingService()
            };
        },

		mounted() {
			// this.eventBusEmit('trigger:simplert', {
			// 	title: 'Create Wedding',
			// 	message: 'Create your wedding or add a new one',
			// 	type: 'info',
			// 	onClose: this.onClose
			// });
		},

        methods: {
	        onSubmit() {
		        this.weddingService.add(this.form.data()).then(data => {

		            if (data.wedding) {
                        this.eventBusEmit('trigger:simplert', {
                            title: 'Wedding created',
                            message: '',
                            type: 'success',
                            onClose: this.onClose
                        });

                        this.clearForm();
                        this.showGoBack = true;
                    }

            });
	        },
          clearForm() {
	        	this.form = new Form({
			        brideName: '',
			        groomName: '',
			        location: '',
			        guests: 0,
			        date: null,
		        });
          },
	        hideGoBack() {
	        	this.showGoBack = false;
          }
        }
	}
</script>

