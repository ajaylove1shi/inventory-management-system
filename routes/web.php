<?php

use Illuminate\Support\Facades\Route;

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

/**
|-----------------------------------------------
| Dashboard Un Authenticated Routes.......
|-----------------------------------------------
 */

Route::group(['namespace' => 'Dashboard'], function () {

    /**
    |-----------------------------------------------
    | Authentication Routes.......
    |-----------------------------------------------
     */

    Route::group(['namespace' => 'Auth'], function () {

        /**
        |-----------------------------------------------
        | Login Routes.......
        |-----------------------------------------------
         */
        Route::get('/', 'LoginController@showLoginForm');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        /**
        |-----------------------------------------------
        | Registration Routes.......
        |-----------------------------------------------
         */
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

    });

});

/**
|-----------------------------------------------
| Authenticated Routes.......
|-----------------------------------------------
 */
Route::group(['namespace' => 'Dashboard', 'middleware' => ['auth']], function () {

    /**
    |-----------------------------------------------
    | Dashboard Routes.......
    |-----------------------------------------------
     */
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /**
    |-----------------------------------------------
    | Categories Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Category'], function () {
        Route::resource('categories', 'CategoryController')->except('create','show');
    });


    /**
    |-----------------------------------------------
    | Products Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Product'], function () {
        Route::post('products/ratings', 'ProductController@ratings')->name('products.ratings');
        Route::post('products/image/delete/{id}', 'ProductController@deleteImages')->name('products.image.delete');
        Route::resource('products', 'ProductController');
        //->except('create','show');
    });


    /**
    |-----------------------------------------------
    | Attributes Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Attribute'], function () {
        Route::post('attributes/values', 'AttributeController@attributeValues')->name('attribute.values');
        Route::resource('attributes', 'AttributeController')->only('store','update','destroy');
    });

    /**
    |-----------------------------------------------
    | Attribute Values Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'AttributeValue'], function () {
        Route::resource('attribute-values', 'AttributeValueController')->only('store','update','destroy');
    });


    /**
    |-----------------------------------------------
    | Variation Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Variation'], function () {
        Route::resource('variations', 'VariationController')->only('store','update','destroy');
    });

    /**
    |-----------------------------------------------
    | Comment Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Comment'], function () {
        Route::resource('comments', 'CommentController')->only('store','update','destroy');
    });

     /**
    |-----------------------------------------------
    | Feedback Routes.......
    |-----------------------------------------------
     */
    Route::group(['namespace' => 'Feedback'], function () {
        Route::resource('feedbacks', 'FeedbackController')->only('store','update','destroy');
    });

});