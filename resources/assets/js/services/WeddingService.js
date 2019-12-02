/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class WeddingService extends BaseApiService {

	constructor() {
		super("wedding");
	}

	upcoming() {
		return this.custom("get", "upcoming-weddings", {});
	}

}