
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import router from './config/router';
import './config/components';
import './config/filters';

import UserService from './services/UserService';

import { EventBus } from './utilities/event-bus.js';

// Configure app
const app = new Vue({
  el: '#app',

	router,

  created() {

  },

  mounted() {

	  EventBus.$on('trigger:simplert', (data) => this.$refs.simplert.openSimplert(data));

	  (new UserService).current().then(data => {
		  this.user = data;
		  sessionStorage.setItem('userInfo', JSON.stringify(data));
	  }).then(() => {
		  if (this.showWelcomeMessage) this.showWelcomeBackMessage();
	  });
  },

  data: {
    user: {},
	  showWelcomeMessage : false
  },

  methods: {
		showWelcomeBackMessage() {
			EventBus.$emit('trigger:simplert', {
				title: 'Welcome Back',
				message: this.user.name,
				type: 'info',
				onClose: this.onClose
			});
		}
  }
});