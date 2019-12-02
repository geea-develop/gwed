/**
 * Created by guy on 10/07/17.
 */
import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('../views/Home')
	},
	{
		name: 'createWedding',
		path: '/wedding',
		component: require('../views/CreateWedding')
	},
	{
		name: 'editWedding',
		path: '/wedding/:id',
		component: require('../views/EditWedding')
	},
    {
        name: 'product',
        path: '/product/:id',
        component: require('../views/Product')
    },
	{
		name: 'vendors',
		path: '/vendors',
		component: require('../views/Vendors')
	},
	{
		name: 'professions',
		path: '/professions',
		component: require('../views/Professions')
	},
	{
		name: 'products',
		path: '/products',
		component: require('../views/Products')
	}
];

export default new VueRouter({
	linkActiveClass: 'active',
	routes
});
