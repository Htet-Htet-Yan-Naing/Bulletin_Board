<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

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
  
    public function login()
    {
        return view('auth/login');
    }

    //Login action
    public function loginAction(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email can\'t be blank.',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password can\'t be blank.'
        ]);
        $user = User::where('email', $validatedData['email'])->first();
       if($user){
        if (Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.postList');
            } else {
                return redirect()->route('user.postList');
            }
        }
        else{
            return redirect()->back()->with('success', 'Incorrect password');
        }
    }
    else{
            return redirect()->back()->with('success', 'Email  does\'t exit.');
    }
    }
    
    //Logout action
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/login');
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
            $newConfirmPw = Hash::make($request->pw_confirmation);
            $user->password = $newPw;
            $user->save();
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.userList');
            } else {
                return redirect()->route('user.userList');
            }
        }
    }
    public function showForgetPasswordForm(Request $request)
    {
        return view('auth.forgetPassword');
    }
    public function submitForgetPasswordForm(Request $request)
    {
        $request->session()->put('reset_password_email', $request->email);
        $user = User::where('email', $request->email)->first();
        $name = $user->name;
        if (!$user) {
                return back()->with('success', 'Email not found');
        }
        $token = Str::random(64);
  
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);
          Mail::send('email.forgetPassword', ['token' => $token,'name' => $name], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with('success', 'Email sent with password reset instructions.');
    }
    public function showResetPasswordForm(Request $request,$token)
    {
        return view('auth.resetPassword',  ['token' => $token]);
    }
   
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);
        $email = $request->session()->get('reset_password_email');
        $updatePassword = DB::table('password_reset_tokens')
                            ->where([
                              'email' =>  $email, 
                              'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            dd($updatePassword);
            return back()->withInput()->with('success', 'Invalid token!');
        }

        $user = User::where('email', $email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $email])->delete();
        
        return redirect()->route('login')->with('success', 'Password has been reset');
    }
}
