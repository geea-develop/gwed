<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $weddings = App\Models\Wedding::upcomingWeddings()->take(10)->get(['brideName', 'groomName', 'date']);

    return view('welcome', compact('weddings'));
})->name('welcome');

Route::get('/shop', 'ProductController@index')->name('shop');
Route::get('/shop/product/{id}', 'ProductController@show')->name('product');
Route::get('/shop/category/{category}', 'ProductController@showCategory')->name('category');

Route::get('/about', function () { return view('about'); })->name('about')
;
Route::get('/documentation', function () { return view('documentation'); })->name('documentation');

Route::get('contact', 'ContactController@create')->name('contact.create');
Route::post('contact', 'ContactController@store')->name('contact.store');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/logout', function() {
   return redirect()->route('dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');
