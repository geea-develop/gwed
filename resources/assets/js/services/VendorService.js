/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class VendorService extends BaseApiService {

	constructor() {
		super("vendor");
	}

	byWedding(id) {
		return this.custom("get", "vendors/by-wedding/" + id, {});
	}

	attachToWedding(vendorId, weddingId) {
		return this.custom("post", "wedding-vendor", {vendorId: vendorId, weddingId: weddingId});
	}

	detachFromWedding(id) {
		return this.custom("delete", "wedding-vendor/" + id, {});
	}

}