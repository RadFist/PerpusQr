<?php

use App\Http\Controllers\Authentication as ControllersAuthentication;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TestingController;
use App\Http\Middleware\authentication;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;


//auth routes
Route::get('/login', [ControllersAuthentication::class, 'loginPage']);

Route::get('/register', [ControllersAuthentication::class, 'registerPage']);

Route::post('/login', [ControllersAuthentication::class, 'login'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/register', [ControllersAuthentication::class, 'registration']);

Route::post('/logout', [ControllersAuthentication::class, 'logout'])
    ->withoutMiddleware([VerifyCsrfToken::class]);


Route::get('/', function () {
    return redirect('/dashboard');
});


Route::get('/Home', function () {
    return redirect('/dashboard');
});

Route::get('/testing', [TestingController::class, 'index']);


//protected routes
Route::middleware([authentication::class])->group(function () {
    Route::get('/dashboard', DashboardController::class);

    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('borrow', BorrowController::class);

    Route::post('borrow/dikembalikan/{id}', [BorrowController::class,  'returning'])->name('borrow.return');

    Route::post('API/borrow/scan', [BorrowController::class, 'Scanning']);
});
