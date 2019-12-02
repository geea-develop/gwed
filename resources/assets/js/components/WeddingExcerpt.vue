<template>
    <div>

        <div class="d-flex">
            <div class="mr-auto">
                <p>
                    {{ wedding.brideName }} & {{ wedding.groomName }}
                    <span class="badge badge-light">
                        {{ wedding.date | dateFormat }}
                    </span>
                </p>
            </div>
            <div class="btn-group-sm" role="group" aria-label="Basic example">
                <router-link :to="{ name: 'editWedding', params: { id: wedding._id }}" class="btn btn-sm btn-outline-primary align-middle" v-if="showEdit">Edit</router-link>
                <button type="button" class="btn btn-sm btn-outline-danger" v-on:click="remove(wedding._id)" v-if="showDelete">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
	import WeddingService from '../services/WeddingService';
	import { EventBus } from '../utilities/event-bus.js';
	import BaseComponent from './BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['wedding', 'showDelete', 'showEdit'],

    mounted() {

    },

    methods : {
	    remove(id) {
		    (new WeddingService).remove(id).then(data => {
			    this.eventBusEmit('trigger:simplert', {
				    title: 'Delete Wedding',
				    message: 'Your wedding was deleted',
				    type: 'success',
				    onClose: this.onClose
			    });
        });
      },
      onClose() {
	      this.eventBusEmit('trigger:reload-weddings');
      }
    }
	}
</script>