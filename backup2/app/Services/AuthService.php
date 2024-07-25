<?php
namespace App\Services;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthService
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
        }
    }
  
    public function login()
    {
        return view('auth/login');
    }

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
        return $user;
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return $user;
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
            Auth::guard('web')->logout(); 
            $request->session()->invalidate();
            return redirect()->route('login')->with('success','Password updated successfully.');
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
        
        if (!$user) {
            return $user;
        }
        $name = $user->name;
        $token = Str::random(64);
  
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);
          $data = [
            'token'=>$token,
            'email' => $request->email,
             'name'=>$name,
            ];
          Mail::to($request->email)->send(new SendMail($data));
        return $user;
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
            return -1;
        }
        $user = User::where('email', $email)
                    ->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email'=> $email])->delete();
        return $user;
    }
}