/**
 * Created by guy on 18/08/17.
 */
import { EventBus } from '../utilities/event-bus.js';

export default {

	methods: {
		triggerSimplert(data) {
			this.eventBusEmit('trigger:simplert', data);
		},
		eventBusEmit(event, data) {
			EventBus.$emit(event, data);
		},
		eventBusOn(event, callback) {
			EventBus.$on(event, callback);
		}
	}
}