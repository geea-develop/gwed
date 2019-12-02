/**
 * Created by guy on 11/07/17.
 */

import BaseApiService from './BaseApiService';

export default class ProductService extends BaseApiService {

	constructor() {
		super("product");
	}

	latest() {
		return this.custom("get", "latest-products", {});
	}

}