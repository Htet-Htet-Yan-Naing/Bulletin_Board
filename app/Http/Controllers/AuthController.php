<?php


namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup()
    {
        return view("auth/signup");
    }
    public function signupSave(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'pw' => 'required|min:4',
            'pw_confirmation' => 'same:newPw',
        ], [
            'name.required' => 'The name field can\'t be blank.',
            'email.required' => 'The email field can\'t be blank.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'pw.required' => 'The password field can\'t be blank.',
            'pw.min' => 'The password must be at least 4 characters.',
            'pw_confirmation.same' => 'The password confimation field must match the new password field.'
        ]);
        if (Auth::check()) {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['pw']),
                'type' => "1",
                'create_user_id' => 1,
                'updated_user_id' => 1
            ]);
            $user->create_user_id = auth()->id();
            $user->updated_user_id = auth()->id();
            $user->save();
            return redirect()->route('login');
        } else {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['pw']),
                'type' => "1",
                'create_user_id' => 1,
                'updated_user_id' => 1
            ]);
            $user->create_user_id = $user->id;
            $user->updated_user_id = $user->id;
            $user->save();
            return redirect()->route('login');
        }
    }
    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('auth.change_password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'newPw' => 'required|min:4',
            'pw_confirmation' => 'same:newPw',
        ], [
            'newPw.required' => 'The password field can\'t be blank.',
            'newPw.min' => 'The password must be at least 4 characters.',
            'pw_confirmation.same' => 'The password confimation field must match the new password field.'
        ]);
        $user = User::findOrFail($id);
        if (!Hash::check($request->currentPw, $user->password)) {
            return back()->withErrors(['currentPw' => 'Current password is incorrect']);
        } else {
            $newPw = Hash::make($request->newPw);
            $newConfirmPw =  Hash::make($request->pw_confirmation);
                $user->password = $newPw;
                $user->save();
                if (auth()->user()->type == 'admin') {
                    return redirect()->route('admin.userList');
                } else {
                    return redirect()->route('user.userList');
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
    public function login()
    {
        return view('auth/login');
    }

    //Login action
    public function loginAction(Request $request)
    {
        //check login or not
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
        //After authentication or  after user login
        $request->session()->regenerate();
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }

    //Logout action
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
