<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login', ['name' => 'James']);
});
Route::post('/login', function () {
    return view('login', ['name' => 'James']);
});
