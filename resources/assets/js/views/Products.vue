<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!--<router-link to="/product" class="btn btn-success" v-if="products.length == 0">Create Product</router-link>-->
                        <h4>Products</h4>

                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Add Product
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="card-body">
                                        <add-product></add-product>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--PRODUCTS-->
                        <div v-show="products.length > 0">

                            <div v-bind:class="products.length > 0 ? '' : 'show'">
                                <ul class="list-unstyled" >
                                    <li class="mt-3" v-for="product in products">
                                        <div class="media border-bottom">
                                            <img :src="product.image" class="d-flex align-self-start mr-3 mb-3 rounded" style="width:220px; height:220px;"/>

                                            <div class="media-body">

                                                <div class="media">
                                                    <img :src="product.logo" class="d-flex align-self-start mr-3 rounded-circle" style="width:100px; height:100px;"/>

                                                    <div class="media-body">
                                                        <div class="d-flex w-100 justify-content-between">

                                                            <div>

                                                                <router-link :to="{ name: 'product', params: { id: product._id }}" title="Edit">
                                                                    <h5>
                                                                        {{ product.title }}
                                                                    </h5>
                                                                </router-link>
                                                                <p class="text-secondary mt-2">{{product.brand}}</p>
                                                                <span class="badge badge-secondary mt-2">{{ product.category }}</span>
                                                            </div>

                                                            <div>
                                                                <p>{{ product.price | currencyFormat }} NIS</p>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <p class="mt-3">{{ product.description }}</p>
                                                <div class="d-flex w-100 justify-content-between">

                                                    <p> <a v-bind:href="'/shop/product/' + product.uname" title="Share">View in shop</a>
                                                    </p>
                                                    <button type="button" class="btn btn-sm btn-danger" @click="remove(product)">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <!--END PRODUCTS-->

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
	import ProductService from '../services/ProductService';
	import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
			return {
				products: [],
			};
		},

		mounted() {
			this.loadProducts();
			this.eventBusOn('trigger:reload-products', this.loadProducts);
		},

		methods : {
			loadProducts() {
				(new ProductService()).all().then(data => this.products = data.products);
            },
            remove(product) {
                (new ProductService()).remove(product._id).then(data => {
                    this.triggerSimplert({
                        title: 'Product has been removed',
                        message: '',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.eventBusEmit('trigger:reload-products', {});
                })
            }
        }
	}
</script>

