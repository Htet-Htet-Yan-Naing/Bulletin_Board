<?php
namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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
    //Route::post('/update/{id}', 'PostsController@update')->name("update");
    Route::post('/update/{id}', [PostsController::class, 'update'])->name("update"); 
});
//Route::get('/home',[HomeController::class,'index'] )->name('home');
//Normal Users Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/adminPostList', [PostsController::class, 'adminPostList'])->name('admin.postList');
    //Route::get('/adminCreatePost', [PostsController::class, 'createPost'])->name("createPost");
    //Route::get('/confirmPost', [PostsController::class, 'confirmPost'])->name("confirmPost");
    //Route::post('/postSave', 'PostsController@postSave')->name("postSave");
    //Route::get('/edit/{id}', [PostsController::class, 'edit'])->name("edit");
    //Route::post('/confirmEdit/{id}', 'PostsController@confirmEdit')->name("confirmEdit");
    //Route::post('/update/{id}', 'PostsController@update')->name("update");
    //Route::get('/postList', 'PostsController@postList')->name('postList');
});
 
//Admin Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/userPostList', [PostsController::class, 'userPostList'])->name('user.postList');
    //Route::get('/userList', [UserController::class, 'userList'])->name('userList');
    //Route::get('/userList', 'UserController@userList')->name('userList');
    //Route::get('/createPost', [PostsController::class, 'createPost'])->name("createPost");
    //Route::get('/confirmPost', [PostsController::class, 'confirmPost'])->name("confirmPost");
    //Route::post('/postSave', [PostsController::class, 'postSave'])->name("post.save");
    //Route::get('/edit/{id}', [PostsController::class, 'edit'])->name("edit");
    //Route::get('/edit/{id}', 'PostsController@edit')->name("edit");
    //Route::post('/confirmEdit/{id}', 'PostsController@confirmEdit')->name("confirmEdit");
    //Route::post('/update/{id}', 'PostsController@update')->name("update");
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //Route::get('/postList', 'PostsController@postList')->name('posts.postList');
    // Route::get('/createPost', 'PostsController@createPost');
    // Route::post('/confirmPost', 'PostsController@confirmPost')->name("confirmPost");
    // Route::post('/store', 'PostsController@store')->name("store");
    // Route::get('/edit/{id}', 'PostsController@edit')->name("edit");
    // Route::post('/confirmEdit/{id}', 'PostsController@confirmEdit')->name("confirmEdit");
    // Route::post('/update/{id}', 'PostsController@update')->name("update");
    //Upload CSV file
    Route::get('/uploadCSV', 'PostsController@uploadCSV')->name("uploadCSV");
    //Users
    Route::get('/register', 'UserController@register');
    Route::post('/confirmRegister', 'UserController@confirmRegister')->name("confirmRegister");
    //User List
    //Route::get('/userList', 'UserController@userList')->name('users.userList');
    //User Profile
    Route::get('/profile/{id}', 'UserController@profile')->name("profile");
    Route::get('/editProfile/{id}', 'UserController@editProfile')->name("editProfile");
    //Change Password
    Route::get('/change_password/{id}', 'UserController@changePassword')->name('change_password');
    //Update Password
    Route::put('/update_password/{id}', 'UserController@updatePassword')->name('update_password');
    //Forgot Password
    Route::get('/forgot_password', 'UserController@forgotPassword')->name('auth.forgot_password');
    //Reset Password
    Route::get('/reset_password', 'UserController@resetPassword')->name('auth.reset_password');
});
