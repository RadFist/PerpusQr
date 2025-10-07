<?php

use App\Http\Controllers\Authentication as ControllersAuthentication;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\authentication;
use Illuminate\Support\Facades\Route;


//auth routes
Route::get('/login', [ControllersAuthentication::class, 'loginPage']);

Route::get('/register', [ControllersAuthentication::class, 'registerPage']);

Route::post('/login', [ControllersAuthentication::class, 'login']);

Route::post('/register', [ControllersAuthentication::class, 'registration']);

Route::post('/logout', [ControllersAuthentication::class, 'logout']);


Route::get('/', function () {
    return view('welcome');
});


Route::get('/Home', function () {
    return redirect('/dashboard');
});

//protected routes
Route::middleware([authentication::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('books', BookController::class);
});
