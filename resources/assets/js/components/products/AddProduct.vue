<template>

	<div >

		<div class="form-group row">
			<label class="col-md-4 col-form-label"> Image</label>
			<div class="col-md-2">
				<img :src="form.image" id="product_image" class="img-responsive" style="width:80px;height:80px;">
			</div>
			<div class="col-md-4">
				<input type="file" v-on:change="onImageChange" class="form-control">
			</div>
			<div class="col-md-2">
				<button class="btn btn-success btn-block" @click="uploadImage" :disabled="uploadDisabled['image']">Upload</button>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-4 col-form-label"> Brand Logo</label>
			<div class="col-md-2">
				<img :src="form.logo" id="product_logo" class="img-responsive" style="width:80px;height:80px;">
			</div>
			<div class="col-md-4">
				<input type="file" v-on:change="onLogoChange" class="form-control">
			</div>
			<div class="col-md-2">
				<button class="btn btn-success btn-block" @click="uploadLogo" :disabled="uploadDisabled['logo']">Upload</button>
			</div>
		</div>

		<form @submit.prevent="onSubmit"
			  @keydown="productService.apiService.errors.clear($event.target.name)">

			<input type="hidden" v-model="form.image" name="image" />
			<input type="hidden" v-model="form.logo" name="logo"/>

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
					<button class="btn btn-primary" :disabled="productService.apiService.errors.any()">Add Product</button>
				</div>
			</div>
		</form>
	</div>

</template>

<script>
	import Form from '../../utilities/form';
	import ProductService from '../../services/ProductService';
	import BaseComponent from '../BaseComponent';

	export default {

		extends: BaseComponent,

		data() {
			return {
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
				productService : new ProductService(),
                uploadDisabled: {
				    'image' : true,
				    'logo' : true
                }
			};
		},

		mounted() {

		},

		methods: {
			onSubmit() {
				this.productService.add(this.form.data()).then(data => {
					this.triggerSimplert({
						title: 'Add Product',
						message: 'New Product has been added',
						type: 'success',
						onClose: this.onClose
					});
					this.clearForm();
					this.eventBusEmit('trigger:reload-products', {});
				});
			},
			clearForm() {
				this.form = new Form({
                    title: "",
                    description: "",
                    logo: "",
                    image: "",
                    uname: "",
                    price: 1,
                    brand: "",
                    category: ""
				});
                $('#product_logo').attr('src', "");
                $('input[name="logo"]').attr('value', '');

                $('#product_image').attr('src', "");
                $('input[name="image"]').attr('value', '');

                $('input[type="file"]').attr('value', '');

                this.productService.apiService.errors.clear();
			},
            onFileChange(e, type) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0], type);
            },
            onImageChange(e) {
                return this.onFileChange(e, 'image');
            },
            onLogoChange(e) {
                return this.onFileChange(e, 'logo');
            },
            createImage(file, type) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm[type] = e.target.result;
                };
                reader.readAsDataURL(file);
                this.uploadDisabled[type] = false;
            },
			uploadImage() {
			  	return this.upload('image');
			},
            uploadLogo() {
                return this.upload('logo');
            },
            upload(type){
			    let params = {};
                let vm = this;
			    params[type] = vm[type];
                this.uploadDisabled[type] = true;

                axios.post('/api/product/upload-'+type, params).then(data => {
					    if (data.data.store) {
                            this.triggerSimplert({
                                title: 'Upload success',
                                message: '',
                                type: 'success',
                                onClose: this.onClose
                            });
                            this.form[type] = data.data.path;
                            $('#product_'+type).attr('src', this.form[type]);
                            $('input[name="'+type+'"]').attr('value', this.form[type]);
						} else {
                            this.triggerSimplert({
                                title: 'Upload failed',
                                message: '',
                                type: 'error',
                                onClose: this.onClose
                            });
                            this.uploadDisabled[type] = false;
						}
                });
            }
		}
	}
</script>

