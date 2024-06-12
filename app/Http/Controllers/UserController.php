<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function login()
{
    return view('users.login');
}
public function userList()
{
    $users= User::Paginate(1);
    return view('users.user_list',compact('users'));
}
public function register()
{
    return view('users.create_user');
}
public function confirmRegister(\Illuminate\Http\Request $request)
{
    
    $user = $request;
    $imageName=time().'.'.$request->profile->extension();
        $success=$request->profile->move(public_path('img'),$imageName);
        $imagePath = 'img/' . $imageName;
    return view('users.create_user_confirm',compact('user','imagePath'));
}
}
