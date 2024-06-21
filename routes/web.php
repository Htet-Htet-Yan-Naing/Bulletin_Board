<?php
namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('signup', 'signup')->name('signup');
    Route::post('signup', 'signupSave')->name('signup.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/createPost', [PostsController::class, 'createPost'])->name("createPost");
    Route::get('/confirmPost', [PostsController::class, 'confirmPost'])->name("confirmPost");
    Route::get('/searchPost', [PostsController::class, 'searchPost'])->name("searchPost");
    Route::post('/postSave', [PostsController::class, 'postSave'])->name("post.save");
    Route::get('/edit/{id}', [PostsController::class, 'edit'])->name("edit");
    Route::post('/confirmEdit/{id}', [PostsController::class, 'confirmEdit'])->name("confirmEdit");
    Route::post('/update/{id}', [PostsController::class, 'update'])->name("update"); 
    Route::delete('/postlists/{id}/destroy', [PostsController::class, 'destroy'])->name('post.destroy');
    route::get('/posts/download',[PostsController::class, 'download'])->name('posts.download');
    Route::get('/posts/upload',  [PostsController::class, 'upload'])->name("posts.upload");
    Route::post('/posts/uploadCSV',  [PostsController::class, 'uploadCSV'])->name("posts.uploadCSV");
    Route::get('/register', [UserController::class, 'register']);
    Route::post('/confirmRegister',  [UserController::class, 'confirmRegister'])->name("confirmRegister");
    Route::get('/profile/{id}',  [UserController::class, 'profile'])->name("profile");
    Route::get('/editProfile/{id}',  [UserController::class, 'editProfile'])->name("editProfile");
});
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/adminPostList', [PostsController::class, 'adminPostList'])->name('admin.postList');
});
 
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/userPostList', [PostsController::class, 'userPostList'])->name('user.postList');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //Change Password
    Route::get('/change_password/{id}', 'UserController@changePassword')->name('change_password');
    //Update Password
    Route::put('/update_password/{id}', 'UserController@updatePassword')->name('update_password');
    //Forgot Password
    Route::get('/forgot_password', 'UserController@forgotPassword')->name('auth.forgot_password');
    //Reset Password
    Route::get('/reset_password', 'UserController@resetPassword')->name('auth.reset_password');
});
