<template>
    <div class="card">
        <div class="card-title">Upcoming Weddings</div>

        <div class="card-body">
            <ul>
                <li v-for="wedding in weddings">
                    <wedding-excerpt :wedding="wedding"></wedding-excerpt>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
	import WeddingService from '../services/WeddingService';
	import BaseComponent from './BaseComponent';

    export default {

	    extends: BaseComponent,

       data() {
           return {
	           weddings : []
           }
        },

        mounted() {
          (new WeddingService).upcoming().then(data => this.weddings = data.weddings)
        }
    }
</script>
