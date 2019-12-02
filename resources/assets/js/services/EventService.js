/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class EventService extends BaseApiService {

	constructor() {
		super("event");
	}

	byWedding(id) {
		return this.custom("get", "events/by-wedding/" + id, {});
	}

    upload(id, data) {
        return this.custom("post", "events/upload-to-wedding/" + id, data);
    }

}