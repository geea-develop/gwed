/**
 * Created by guy on 11/07/17.
 */
import ApiService from './ApiService';

export default class BaseApiService {

	constructor(path) {
		this._path = path;
		this.apiService = new ApiService();
	}

	add(data) {
		return this.apiService.add(this._path, data);
	}

	update(id, data) {
		return this.apiService.update(this._path + "/" + id, data);
	}

	remove(id) {
		return this.apiService.remove(this._path + "/" + id);
	}

	find(id) {
		return this.apiService.find(this._path + "/" + id);
	}

	all() {
		return this.apiService.find(this._path);
	}

	custom(reqType, url, data) {
		return this.apiService.execute(reqType, url, data);
	}

	get path() {
		return this._path;
	}

	set path(value) {
		this._path = value;
	}
}