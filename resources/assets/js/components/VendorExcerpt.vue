<template>
    <div>
        <div class="col-md-4">
            <p> {{ vendor.name }} </p>
        </div>
        <div class="col-md-4">
            <p> {{ vendor.email }} </p>
        </div>
        <div class="col-md-4">
            <p> {{ vendor.phone }} </p>
            <!--<router-link :to="{ name: 'editVendor', params: { id: vendor._id }}" class="btn btn-default" >Edit Vendor</router-link>-->
            <!--<button type="button" class="btn btn-danger" v-on:click="remove(vendor._id)" v-if="showDelete">Delete Vendor</button>-->
        </div>
    </div>
</template>

<script>
	import VendorService from '../services/VendorService';
	import BaseComponent from './BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['vendor', 'showDelete', 'showEdit'],

    mounted() {

    },

    methods : {
	    remove(id) {
		    (new VendorService).remove(id).then(data => {
			    alert('Success');
			    window.location.href = '/dashboard';
        });
      }
    }
	}
</script>