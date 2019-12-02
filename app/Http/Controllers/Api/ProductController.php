<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotOwnerException;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('createdAt', 'DESC')->get();
        
        return compact('products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'string|max:255|required',
            'description'   => 'sometimes|string|max:500',
            'uname'         => 'sometimes|string|max:120|unique:products',
            'price'         => 'sometimes|numeric|min:1',
            'image'         => 'sometimes|url',
            'logo'          => 'sometimes|url',
            'category'      => 'sometimes|string',
            'brand'         => 'sometimes|string',
        ]);

        $uname = $request->exists('uname') ? $request->input('uname') : Carbon::now()->getTimestamp();
        $price = $request->exists('price') ? $request->input('price') : 1;

        $category = $request->exists('category') ? $request->input('category') : 'unknown';

        $brand = $request->exists('brand') ? $request->input('brand') : 'unknown';


        $image = $request->exists('image') ? $request->input('image') : '';

        $logo = $request->exists('logo') ? $request->input('logo') : '';

        $product = Product::create([
            'title'         => (string)$request->input('title'),
            'description'   => (string)$request->input('description'),
            'price'         => (float)$price,
            'uname'         => (string)$uname,
            'category'      => (string)$category,
            'brand'         => (string)$brand,
            'image'         => (string)$image,
            'logo'          => (string)$logo,
        ]);

        return compact('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return compact('product');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'title'         => 'string|max:255|required',
            'description'   => 'sometimes|string|max:500',
            'uname'         => 'sometimes|string|max:120|unique:products,_id,'.$product->_id,
            'price'         => 'sometimes|numeric|min:1',
            'image'         => 'sometimes|url',
            'logo'          => 'sometimes|url',
            'category'      => 'sometimes|string',
            'brand'         => 'sometimes|string',
        ]);

        $product->update([
            'title' => (string)$request->input('title'),
            'description' => (string)$request->input('description'),
            'price' => (float)$request->input('price'),
            'uname' => (string)$request->input('uname'),
            'category' => (string)$request->input('category'),
            'brand' => (string)$request->input('brand'),
        ]);

        return compact('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!Auth::user()->admin)
            throw new NotOwnerException();

        $product->delete();

        return response()->json();
    }

    public function uploadImage(Request $request)
    {
        $upload = $this->upload($request, 'image');

        return response()->json($upload);
    }

    public function uploadLogo(Request $request)
    {
        $upload = $this->upload($request, 'logo');

        return response()->json($upload);
    }

    /**
     * @param Request $request
     * @param $type
     * @return string
     */
    private function upload(Request $request, $type)
    {

        $imageData = $request->get($type);

        $fileName = uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];

        $path = "storage/images/products/{$type}/{$fileName}";

        $image = Image::make($request->get($type));

        if ($type === 'image')
            $image->resize('640', '480');

        if ($type === 'logo')
            $image->resize('150', '150');

        $resource = $image->stream()->detach();

        $store = Storage::disk('s3')->put(
            $path,
            $resource
        );

        $path = "https://s3." . config('filesystems.disks.s3.region') . ".amazonaws.com/" . config('filesystems.disks.s3.bucket') . "/{$path}";

        return compact('store', 'path');
    }
}
