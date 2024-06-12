<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function login()
{
    return view('auth.login');
}
public function changePassword()
{
    return view('auth.change_password');
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
public function profile(string $id)
{ 
    $user = User::findOrFail($id);
        $imageName = $user->profile;
    $imagePath = 'img/' . $imageName;
    return view('users.show_profile', compact('user','imagePath'));
}

public function editProfile(\Illuminate\Http\Request $request,$id)
{
    $user = User::findOrFail($id);
    $imageName = $user->profile;
    $imagePath = 'img/' . $imageName;
    return view('users.edit_profile',compact('user','imagePath'));
}

}
