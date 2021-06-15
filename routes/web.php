<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'UploadController@index')->name('upload_screen');
Route::post('/upload', 'UploadController@upload')->name('upload');

