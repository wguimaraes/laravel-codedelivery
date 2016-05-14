<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Routing\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/admin/categories', 'CategoriesController@index');
Route::get('/admin/categories/create', ['as' => 'admin.categories.create', 'uses' => 'CategoriesController@create']);
Route::post('/admin/categories/store', ['as' => 'admin.categories.store', 'uses' => 'CategoriesController@store']);
