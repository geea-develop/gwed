<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Professions</h4>

                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Add Profession
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="card-body">
                                        <add-profession></add-profession>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!--PROFESSIONS-->
                        <div class="mt-3" v-if="professions.length > 0">

                            <table class="table" id="professions">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name Name</th>
                                    <th scope="col">Unique Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="profession in professions">
                                    <th scope="row" ></th>
                                    <td>
                                        <div v-if="editProfessionId !== profession._id">
                                            {{profession.name}}
                                        </div>

                                        <div v-if="editProfessionId === profession._id">
                                            <input type="text" id="name" name="name" class="input input-inline form-control" v-model="form.name">

                                            <span class="note note-danger"
                                                  v-if="professionService.apiService.errors.has('name')"
                                                  v-text="professionService.apiService.errors.get('name')"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="editProfessionId !== profession._id">
                                            {{profession.uname}}
                                        </div>

                                        <div v-if="editProfessionId === profession._id">
                                            <input type="text" id="uname" name="uname" class="input input-inline form-control" v-model="form.uname">

                                            <span class="note note-danger"
                                                  v-if="professionService.apiService.errors.has('uname')"
                                                  v-text="professionService.apiService.errors.get('uname')"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="editProfessionId !== profession._id">
                                        {{profession.description}}
                                        </div>

                                        <div v-if="editProfessionId === profession._id">
                                            <input type="text" id="description" name="description" class="input input-inline form-control" v-model="form.description">

                                            <span class="note note-danger"
                                                  v-if="professionService.apiService.errors.has('description')"
                                                  v-text="professionService.apiService.errors.get('description')"></span>
                                        </div>

                                    </td>
                                    <td>
                                        <!-- Single button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="javascript:;" class="dropdown-item" @click="edit(profession)" v-if="editProfessionId !== profession._id">Edit</a>
                                                <a href="javascript:;" class="dropdown-item" @click="remove(profession._id)" v-if="editProfessionId !== profession._id">Delete</a>
                                                <a href="javascript:;" class="dropdown-item" @click="cancel()" v-if="editProfessionId === profession._id">Cancel</a>
                                                <a href="javascript:;" class="dropdown-item" @click="save(profession._id)" v-if="editProfessionId === profession._id">Save</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
	import ProfessionService from '../services/ProfessionService';
	import BaseView from './BaseView';
    import Form from "../utilities/form";

	export default {

		extends: BaseView,

		data() {
			return {
				professions: [],
                form: {},
                editProfessionId: null,
                professionService: new ProfessionService()
			};
		},

		mounted() {
			this.loadProfessions();
            this.eventBusOn('trigger:reload-professions', this.loadProfessions);
		},

		methods : {
			loadProfessions() {
				(new ProfessionService()).all().then(data => this.professions = data.professions);
			},
            remove(id) {
                this.professionService.remove(id).then(data => {
                    this.triggerSimplert({
                        title: 'Delete Profession',
                        message: 'Profession has been deleted',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-professions', {});
                })
            },

            edit(profession) {
                this.editProfessionId = profession._id;
                this.form = new Form({
                    name: profession.name,
                    uname: profession.uname,
                    description: profession.description
                });
            },

            save(id) {
                this.professionService.update(id, this.form.data()).then(data => {
                    this.triggerSimplert({
                        title: 'Update Profession',
                        message: 'Profession has been updated',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.cancel();
                })
            },

            cancel() {
                this.editProfessionId = null;
                this.form = {};
            },
		}
	}
</script>

