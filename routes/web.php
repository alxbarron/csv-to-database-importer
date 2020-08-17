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

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/contact-importer', 'ContactController@index')->name('healthCheck');
Route::post('/contact-importer', 'ContactController@uploadFile')->name('uploadFile');
Route::put('/contact-importer', 'ContactController@importContacts')->name('importContacts');
