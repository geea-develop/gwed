<template>
    <div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a href="#basicInfo" id="basicInfoTab" aria-controls="basicInfo" role="tab" data-toggle="tab" class="nav-link active">Basic Info</a>
            </li>
            <li class="nav-item">
                <a href="#wVendors" id="wVendorsTab" aria-controls="wVendors" role="tab" data-toggle="tab" class="nav-link">Vendors</a>
            </li>
            <li class="nav-item">
                <a href="#wGuests" id="wGuestsTab" aria-controls="wGuests" role="tab" data-toggle="tab" class="nav-link">Guests</a>
            </li>
            <li class="nav-item">
                <a href="#wBudget" id="wBudgetTab" aria-controls="wBudget" role="tab" data-toggle="tab" class="nav-link">Budget</a>
            </li>
            <li class="nav-item">
                <a href="#wTimeline" id="wTimelineTab" aria-controls="wTimeline" role="tab" data-toggle="tab" class="nav-link">TimeLine</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="myTabContent">
            <div role="tabpanel" class="tab-pane active" id="basicInfo" aria-labelledby="basicInfoTab">
                <edit-wedding-info :wedding-id="$route.params.id"></edit-wedding-info>
            </div>
            <div role="tabpanel" class="tab-pane" id="wVendors" aria-labelledby="wVendorsTab">
                <wedding-vendors :wedding-id="$route.params.id"></wedding-vendors>
            </div>
            <div role="tabpanel" class="tab-pane" id="wGuests" aria-labelledby="wGuestsTab">
                <wedding-guests :wedding-id="$route.params.id"></wedding-guests>
            </div>
            <div role="tabpanel" class="tab-pane" id="wBudget" aria-labelledby="wBudgetTab">
                <wedding-budget :wedding-id="$route.params.id"></wedding-budget>
            </div>
            <div role="tabpanel" class="tab-pane" id="wTimeline" aria-labelledby="wTimelineTab">
                <wedding-events :wedding-id="$route.params.id"></wedding-events>
            </div>

        </div>
    </div>
</template>

<script>

	import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
			return {

            };
        },

		mounted() {
			// this.eventBusEmit('trigger:simplert', {
			// 	title: 'Edit Wedding',
			// 	message: "Here you can modify and manage your wedding",
			// 	type: 'info',
			// 	onClose: this.onClose
			// });
		},

    methods: {

    }
	}

</script>

