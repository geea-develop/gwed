/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class UserService extends BaseApiService {

	constructor() {
		super("user");
	}

	current() {
		return this.custom("get", "user", {});
	}
}