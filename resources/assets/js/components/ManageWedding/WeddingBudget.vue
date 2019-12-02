<template>

		<div class="card mt-3">

			<div class="card-body">

				<h4>Budget Overview</h4>

				<div class="card-deck mt-3">
					<div class="card border-success">
						<div class="card-header text-success">Budget</div>
						<div class="card-body text-secondary">
							<h5 class="card-title">Wedding Budget</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item">{{ wedding.budget ? wedding.budget : 0 | currencyFormat }}</li>
							</ul>
							<p class="card-text"><small class="text-muted">You can change your budget in Basic Info</small></p>
						</div>
						<div class="card-footer text-success">
							Total: {{ wedding.budget ? wedding.budget : 0 | currencyFormat }}
						</div>
					</div>
					<div class="card border-danger">
						<div class="card-header text-danger">Expenses</div>
						<div class="card-body text-secondary">
							<h5 class="card-title">Vendors</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" v-for="vendor in vendors">{{ vendor.vendor.name }}: {{ vendor.vendor.cost | currencyFormat }}</li>
							</ul>
						</div>
						<div class="card-footer text-danger">
							Total: {{ expenses | currencyFormat }}
						</div>
					</div>
				</div>

				<div class="alert mt-3" v-bind:class="wedding.budget && wedding.budget < expenses ? 'alert-warning' : 'alert-success'">
					<span>Current Balance: </span>
					<span>{{ ((wedding.budget ? wedding.budget : 0) - expenses) | currencyFormat }}</span>
				</div>
				<div v-if="wedding.budget" class="alert alert-info">
					<span v-show="wedding.budget > expenses">Looks like we are on track! :)</span>
					<span v-show="wedding.budget < expenses">Oh no, we might need to cut down a bit :(</span>
				</div>
				<div v-if="!wedding.budget" class="alert alert-info">
					<span v-show="expenses > 0">Oh no, we seem to be missing wedding budget :(</span>
					<span v-show="expenses === 0">We seem to be ok :)</span>
				</div>
			</div>
		</div>

</template>

<script>
	import VendorService from '../../services/VendorService';
	import WeddingService from '../../services/WeddingService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		props: ['weddingId'],

		data() {
			return {
				vendors : [],
				wedding : { budget: 0 },
				expenses: 0,
				weddingService : new WeddingService,
				vendorService : new VendorService,
			}
		},

		mounted() {
			this.loadWedding();
			this.loadVendors();

			this.eventBusOn('trigger:wedding-info-updated', this.loadWedding);
			this.eventBusOn('trigger:reload-vendors', this.loadVendors);
		},

		methods : {
			loadWedding() {
				this.weddingService.find(this.weddingId).then(data => this.wedding = data.wedding);
			},
			loadVendors() {
				this.vendorService.byWedding(this.weddingId).then(data => {
					this.vendors = data.vendors;
					let expenses = 0;
					this.vendors.forEach((vendor) => {
						expenses += vendor.vendor.cost;
					});
					this.expenses = expenses;
				});
			}
		}
	}
</script>
