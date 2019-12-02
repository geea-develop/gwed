<template>
    <div>
        <h4>Product ID: {{$route.params.id}}</h4>

        <div class="form-group row">
            <div class="col-md-4">
                <p>Featured Image</p>
                <img :src="form.image" class="rounded" style="width:220px; height:220px;"/>
            </div>
            <div class="col-md-4">
                <p>Brand Logo</p>
                <img :src="form.logo" class="rounded" style="width:120px; height:120px;"/>
            </div>
        </div>

            <form @submit.prevent="update(productId)"
                  @keydown="productService.apiService.errors.clear($event.target.name)">


                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label"> Product Title</label>

                    <div class="col-md-8">
                        <input type="text" id="title" name="title" placeholder="Product Title" class="input input-inline form-control" v-model="form.title" required>

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('title')"
                              v-text="productService.apiService.errors.get('title')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="uname" class="col-md-4 col-form-label"> Product Uname</label>

                    <div class="col-md-8">
                        <input type="text" id="uname" name="uname" placeholder="Product Uname" class="input input-inline form-control" v-model="form.uname">

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('uname')"
                              v-text="productService.apiService.errors.get('uname')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label"> Product Description</label>

                    <div class="col-md-8">
                        <textarea type="text" id="description" name="description" placeholder="Product Description" class="input input-inline form-control" v-model="form.description"></textarea>

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('description')"
                              v-text="productService.apiService.errors.get('description')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="category" class="col-md-4 col-form-label"> Product Category</label>

                    <div class="col-md-8">
                        <input type="text" id="category" name="category" placeholder="Product Category" class="input input-inline form-control" v-model="form.category">

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('category')"
                              v-text="productService.apiService.errors.get('category')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="brand" class="col-md-4 col-form-label"> Product Brand</label>

                    <div class="col-md-8">
                        <input type="text" id="brand" name="brand" placeholder="Product Brand" class="input input-inline form-control" v-model="form.brand">

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('brand')"
                              v-text="productService.apiService.errors.get('brand')"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label"> Price</label>

                    <div class="col-md-8">
                        <input type="number" step="any" id="price" name="price" class="input input-inline form-control" v-model="form.price">

                        <span class="note note-danger"
                              v-if="productService.apiService.errors.has('price')"
                              v-text="productService.apiService.errors.get('price')"></span>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-block" :disabled="productService.apiService.errors.any()">Save</button>
                    </div>
                </div>
            </form>
    </div>
</template>

<script>

    import Form from '../utilities/form';
    import ProductService from '../services/ProductService';
	import BaseView from './BaseView';

	export default {

		extends: BaseView,

		data() {
			return {
                productId : '',
                form : new Form({
                    title: "",
                    description: "",
                    logo: "",
                    image: "",
                    uname: "",
                    price: 1,
                    brand: "",
                    category: ""
                }),
                productService : new ProductService
            };
        },

		mounted() {
            this.productId = this.$route.params.id;
            this.productService.find(this.productId).then(data => this.setForm(data.product));
		},

        methods: {
            update(id) {
                this.productService.update(id, this.form.data()).then(() => {
                    this.triggerSimplert({
                        title: 'Product saved',
                        message: '',
                        type: 'success',
                        onClose: this.onClose
                    });
                    this.productService.find(id).then(data => this.setForm(data.product));
                });
            },

            setForm(product) {
                this.form = new Form(
                    {
                        title: product.title,
                        description: product.description,
                        logo: product.logo,
                        image: product.image,
                        uname: product.uname,
                        price: product.price,
                        brand: product.brand,
                        category: product.category,

                    }
                );
            }

        }
	}

</script>

