<?php
namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/searchPost', [PostsController::class, 'searchPost'])->name("searchPost");
    Route::get('signup', 'signup')->name('signup');
    Route::post('signup', 'signupSave')->name('signup.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/createPost', [PostsController::class, 'createPost'])->name("createPost");
    Route::get('/confirmPost', [PostsController::class, 'confirmPost'])->name("confirmPost");
    Route::post('/postSave', [PostsController::class, 'postSave'])->name("post.save");
   
    Route::get('/searchUser', [UserController::class, 'searchUser'])->name("searchUser");
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::get('/confirmRegister',  [UserController::class, 'confirmRegister'])->name("confirmRegister");
    Route::post('/confirmRegister',  [UserController::class, 'confirmRegister'])->name("confirmRegister");

//    Route::get('/register', [UserController::class, 'register'])->name('register');
//Route::post('/register', [UserController::class, 'register']);
//Route::get('/confirmRegister', [UserController::class, 'confirmRegister'])->name('confirmRegister');
//Route::post('/confirmRegister', [UserController::class, 'confirmRegister'])->name('user.save');


    Route::post('/userSave', [UserController::class, 'userSave'])->name("user.save");
    Route::get('/edit/{id}', [PostsController::class, 'edit']);
    Route::post('/edit/{id}', [PostsController::class, 'edit'])->name("edit");
    Route::get('/confirmEdit/{id}', [PostsController::class, 'confirmEdit'])->name("confirmEdit");
    Route::post('/update/{id}', [PostsController::class, 'update'])->name("update"); 
    Route::delete('/postlists/{id}/destroy', [PostsController::class, 'destroy'])->name('post.destroy');
    Route::delete('/userlists/{id}/destroy', [UserController::class, 'deleteUser'])->name('user.destroy');
    route::get('/posts/download',[PostsController::class, 'download'])->name('posts.download');
    Route::get('/posts/upload',  [PostsController::class, 'upload'])->name("posts.upload");
    Route::post('/posts/uploadCSV',  [PostsController::class, 'uploadCSV'])->name("posts.uploadCSV");
    Route::get('/profile/{id}',  [UserController::class, 'profile'])->name("profile");
    Route::get('/editProfile/{id}',  [UserController::class, 'editProfile'])->name("editProfile");
    Route::post('/updateProfile/{id}',  [UserController::class, 'updateProfile'])->name("updateProfile");
     Route::get('/change_password/{id}', [AuthController::class, 'changePassword'])->name('change_password');
     Route::put('/update_password/{id}', [AuthController::class, 'updatePassword'])->name('update_password');
});
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/adminPostList', [PostsController::class, 'postlist'])->name('admin.postList');
    Route::get('/admin/userList', [UserController::class, 'userListAdmin'])->name('admin.userList');
    
});
 
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/userPostList', [PostsController::class, 'postlist'])->name('user.postList');
    Route::get('/user/userList', [UserController::class, 'userListUser'])->name('user.userList');
});

Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('post/post-list', [PostsController::class, 'postlist'])->name('postlist');
Route::get('posts', [PostsController::class, 'posts'])->name('posts');
