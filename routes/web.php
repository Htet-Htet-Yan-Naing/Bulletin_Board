<?php

use App\Http\Controllers;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('posts.welcome');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //Posts
    Route::get('/login', 'UserController@login')->name('auth.login');
    Route::get('/postList', 'PostsController@postList')->name('posts.postList');
    Route::get('/createPost', 'PostsController@createPost');
    Route::post('/confirmPost', 'PostsController@confirmPost')->name("confirmPost");
    Route::post('/store', 'PostsController@store')->name("store");
    Route::get('/edit/{id}', 'PostsController@edit')->name("edit");
    Route::post('/confirmEdit/{id}', 'PostsController@confirmEdit')->name("confirmEdit");
    Route::post('/update/{id}', 'PostsController@update')->name("update");
    //Upload CSV file
    Route::get('/uploadCSV', 'PostsController@uploadCSV')->name("uploadCSV");
    //Users
    Route::get('/register', 'UserController@register');
    Route::post('/confirmRegister', 'UserController@confirmRegister')->name("confirmRegister");
    //User List
    Route::get('/userList', 'UserController@userList')->name('users.userList');
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
