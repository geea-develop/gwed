/**
 * Created by guy on 10/07/17.
 */
// Register Filters

Vue.filter('dateFormat', function(date) {
	return moment(date).format('Do MMMM, YYYY');
});

Vue.filter('dateFromNow', function(date) {
	return moment(date).fromNow();
});

Vue.filter('currencyFormat', function(n) {
	return (n).toFixed(2);
});