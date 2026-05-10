<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DevelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {    return view('pages.home');})->name('home');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/news', [NewsController::class, 'admin_index'])->name('news.admin_index');
Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');

// Route::resource('news', NewsController::class);
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::post('/user/{user}/role', [UserController::class, 'changeRole']);

Route::middleware('guest')->group(function () {

    Route::get('/login', [UserController::class, 'loginForm'])->name('login');
    Route::post('/login',[UserController::class, 'loginAuth'])->name('login.auth');
});
Route::middleware('auth')->group(function () {
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::get('/admin/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/admin/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/admin/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
//    Route::delete('/admin/news/{user}', [UserController::class, 'destroy'])->middleware('can:delete,new');

    Route::get('/user/create', [UserController::class, 'create'])
        ->name('user.create'); //        ->middleware('can:create,App\Models\User');

    Route::post('/user', [UserController::class, 'store'])
        ->name('user.store'); //        ->middleware('can:create,App\Models\User');

    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');

    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');

    Route::delete('/user/{user}', [UserController::class, 'destroy'])
        ->middleware('can:delete,user');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/devel', [DevelController::class, 'develForm'])->name('devel');
    Route::post('/devel',[DevelController::class, 'develGo'])->name('devel.go');
    Route::get('/devel/login/{user}', [DevelController::class,'loginAs'])->name('devel.login');

});
