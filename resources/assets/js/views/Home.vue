<template>
    <div class="row mt-3" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <router-link to="/wedding" class="btn btn-success" v-if="weddings.length == 0">Create Wedding</router-link>

                    <!--YOUR WEDDINGS-->
                    <div v-show="weddings.length > 0">
                        <div class="card-title d-flex">
                            <div class="mr-auto">You have {{weddings.length}} {{weddings.length == 1 ? 'wedding' : 'weddings'}}.</div>
                            <router-link to="/wedding" class="btn btn-sm btn-outline-secondary">Add new</router-link>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item pl-0 pr-0" v-for="wedding in weddings">
                                <wedding-excerpt :wedding="wedding" :show-edit="true" :show-delete="true"></wedding-excerpt>
                            </li>
                        </ul>
                    </div>
                    <!--END YOUR WEDDINGS-->

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title pb-2 d-flex">
                        News
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item pl-0 pr-0" v-for="item in [1, 2, 3]">
                            Item {{item}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--PASSPORT ACCESS TOKENS-->
        <passport-main v-show="false"></passport-main>
    </div>

</template>

<script>
  import WeddingService from '../services/WeddingService';
  import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
            return {
            	weddings: [],
            };
        },

		mounted() {
        this.getWeddings();
        this.eventBusOn('trigger:reload-weddings', () => this.getWeddings());
		},

    methods: {
			getWeddings() {
				return (new WeddingService()).all().then(data => this.weddings = data.weddings);
      }
    }
	}
</script>

