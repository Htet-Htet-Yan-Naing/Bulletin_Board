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
    Route::get('/searchUser', [UserController::class, 'searchUser'])->name("searchUser");
    Route::post('/postSave', [PostsController::class, 'postSave'])->name("post.save");
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/confirmRegister',  [UserController::class, 'confirmRegister'])->name("confirmRegister");
    Route::post('/userSave', [UserController::class, 'userSave'])->name("user.save");
    Route::get('/edit/{id}', [PostsController::class, 'edit'])->name("edit");
    Route::post('/confirmEdit/{id}', [PostsController::class, 'confirmEdit'])->name("confirmEdit");
    Route::post('/update/{id}', [PostsController::class, 'update'])->name("update"); 
    Route::delete('/postlists/{id}/destroy', [PostsController::class, 'destroy'])->name('post.destroy');
    Route::delete('/userlists/{id}/destroy', [UserController::class, 'deleteUser'])->name('user.destroy');
    route::get('/posts/download',[PostsController::class, 'download'])->name('posts.download');
    Route::get('/posts/upload',  [PostsController::class, 'upload'])->name("posts.upload");
    Route::post('/posts/uploadCSV',  [PostsController::class, 'uploadCSV'])->name("posts.uploadCSV");
    Route::get('/profile/{id}',  [UserController::class, 'profile'])->name("profile");
    Route::get('/editProfile/{id}',  [UserController::class, 'editProfile'])->name("editProfile");
    Route::post('/updateProfile/{id}',  [UserController::class, 'updateProfile'])->name("updateProfile");
     //Change Password AuthController
     Route::get('/change_password/{id}', [AuthController::class, 'changePassword'])->name('change_password');
     //Update Password
     Route::put('/update_password/{id}', [AuthController::class, 'updatePassword'])->name('update_password');
     //Forgot Password
     Route::get('/forgot_password',  [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
     //Reset Password
     Route::get('/reset_password',  [AuthController::class, 'resetPassword'])->name('auth.reset_password');
});
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/adminPostList', [PostsController::class, 'adminPostList'])->name('admin.postList');
    Route::get('/admin/userList', [UserController::class, 'userListAdmin'])->name('admin.userList');
});
 
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/userPostList', [PostsController::class, 'userPostList'])->name('user.postList');
    Route::get('/user/userList', [UserController::class, 'userListUser'])->name('user.userList');
});

