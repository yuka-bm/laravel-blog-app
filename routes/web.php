<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [PostController::class, 'index'])->name('index');

    # POST
    Route::group(['prefix' => 'post', 'as' => 'post.'], function() {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/show}', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit}', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy}', [PostController::class, 'destroy'])->name('destroy');
    });

    # COMMENT
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{post_id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        Route::patch('/{comment_id}/update', [CommentController::class, 'update'])->name('update');
   });

    # PROFILE
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::get('/{id}/edit_password', [UserController::class, 'editPassword'])->name('edit_password');
        Route::patch('/{id}/update_password', [UserController::class, 'updatePassword'])->name('update_password');
   });
});
