/**
 * Created by guy on 11/07/17.
 */

import Errors from '../utilities/errors';
import { EventBus } from '../utilities/event-bus.js';

export default class ApiService {

	constructor() {
		this._prefix = "api/";
		this.errors = new Errors();
	}

	execute(reqType, url, data) {
		return new Promise((resolve, reject) => {
			axios[reqType](this._prefix + url, data)
				.then(response => {
					this.onSuccess(response.data);
					resolve(response.data);
				})
				.catch(error => {
					if (error.response.status === 401) {
                        EventBus.$emit('trigger:simplert', {
                            title: 'Session Expired',
                            message: "Please log in to continue",
                            type: 'error',
							onClose: function() {
                                window.location.replace("/login");
							}
                        });
					}

					this.onFail(error.response.data);
					reject(error.response.data);
				});
		});
	}

	onSuccess(data) {
		// alert('Success');
	}

	onFail(errors) {
		// alert('Failed');
		this.errors.record(errors);
	}

	add(url, data) {
		return this.execute('post', url, data);
	}

	update(url, data) {
		return this.execute('put', url, data);
	}

	remove(url) {
		return this.execute('delete', url, {});
	}

	find(url) {
		return this.execute('get', url, {});
	}

	all(url) {
		return this.execute('get', url, {});
	}
}
