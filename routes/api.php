<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/', function () {
    return ['api live'];
});

Route::middleware('auth:api')->group(function() {
    Route::resource('/wedding', 'WeddingController');
    Route::get('/weddings', 'WeddingController@index');

    Route::resource('/vendor', 'VendorController');
    Route::get('/vendors', 'VendorController@index');
    Route::get('/vendors/by-wedding/{id}', 'VendorController@byWedding');

    Route::resource('/guest', 'GuestController');
    Route::get('/guests', 'GuestController@index');
    Route::get('/guests/by-wedding/{id}', 'GuestController@byWedding');
    Route::post('/guests/upload-to-wedding/{id}', 'GuestController@upload');

    Route::resource('/event', 'EventController');
    Route::get('/events', 'EventController@index');
    Route::get('/events/by-wedding/{id}', 'EventController@byWedding');
    Route::post('/events/upload-to-wedding/{id}', 'EventController@upload');

    Route::resource('/profession', 'ProfessionController');
    Route::get('/professions', 'ProfessionController@index');

    Route::resource('/wedding-vendor', 'WeddingVendorsController', ['only' => ['store', 'destroy'] ]);

    Route::resource('/product', 'Api\ProductController');
    Route::get('/products', 'Api\ProductController@index');
    Route::post('/product/upload-image', 'Api\ProductController@uploadImage');
    Route::post('/product/upload-logo', 'Api\ProductController@uploadLogo');
});