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
            'pw' => 'required|min:4|confirmed',
        ], [
            'name.required' => 'The name field can\'t be blank.',
            'email.required' => 'The email field can\'t be blank.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'pw.required' => 'The password field can\'t be blank.',
            'pw.min' => 'The password must be at least 4 characters.',
            'pw.confirmed' => 'The password confirmation does not match.',
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
            return redirect()->route('admin.postList');//Go to web.php to route with middleware (compact with user()->type)
        } else {
            return redirect()->route('user.postList');//Go to web.php to route with middleware
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
