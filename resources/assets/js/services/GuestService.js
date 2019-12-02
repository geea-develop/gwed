/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class GuestService extends BaseApiService {

	constructor() {
		super("guest");
	}

	byWedding(id) {
		return this.custom("get", "guests/by-wedding/" + id, {});
	}

	upload(id, data) {
        return this.custom("post", "guests/upload-to-wedding/" + id, data);
	}

}