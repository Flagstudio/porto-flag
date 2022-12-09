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

Route::view('/visits-region', 'visits.region')->name('visits-region');
Route::view('/service', 'services.show')->name('service');
//Route::view('/404', '404.index')->name('404');
Route::view('/pdf-certificate', 'pdf-certificate.pdf')->name('pdf-certificate');
Route::view('/payments/success', 'payments.success')->name('success-page');
Route::view('/error', 'error.index')->name('error');
