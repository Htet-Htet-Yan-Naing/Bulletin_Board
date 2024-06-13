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
public function changePassword(\Illuminate\Http\Request $request,$id)
{
    $user = User::findOrFail($id);
    return view('auth.change_password',compact('user'));
}
public function updatePassword(\Illuminate\Http\Request $request,$id)
{
    $user = User::findOrFail($id);
    $userInputPw=$request->currentPw;
    if($user->password!=$userInputPw){   
            print("Password Wrong");
    }
    else{
            $newPw = $request->newPw;
            $newConfirmPw=$request->newConfirmPw;
            if ($newPw == $newConfirmPw) {
            // $user->password = $request->input('newPw');
            $user->password = $newPw;
            $user->save();
            return redirect()->route('users.userList');
            }
            else{
                print("New password and confirm password are not the same");
            }
      
    }
}
public function forgotPassword()
{
    return view('auth.forgot_password');
}
public function resetPassword()
{
    return view('auth.reset_password');
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
