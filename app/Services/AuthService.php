<?php
namespace App\Services;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
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
    public function signup()
    {
        return view("auth/signup");
    }
    public function signupSave(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pw' => 'required|min:4|confirmed'
        ], [
            'name.required' => 'The name field can\'t be blank.',
            'email.required' => 'The email field can\'t be blank.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'name.unique' => 'The name has already been taken.',
            'pw.required' => 'The password field can\'t be blank.',
            'pw.min' => 'The password must be at least 4 characters.',
            'pw.confirmed' => 'Password confirmation does not match.',
        ]);
        if (Auth::check()) {
            $existingUserByEmail = User::userExistByEmail($request);
            $existingUserByName = User::userExistByName($request);
            if ($existingUserByName) {
                if ($existingUserByName->deleted_at) {
                        $user = User::signUpExistingUser($request, $existingUserByName);
                        $user->create_user_id = auth()->id();
                        $user->updated_user_id = auth()->id();
                        $user->save();
                        Session::flash('success', 'Sign up Successfully.');
                        return redirect()->route('login');
                } else {
                    return redirect()->back()->withErrors(['name' => 'The name has already been taken.'])->withInput();
                }
            }
            if ($existingUserByEmail) {
                if ($existingUserByEmail->deleted_at) {
                    $user = User::signUpExistingUser($request, $existingUserByEmail);
                    $user->create_user_id = auth()->id();
                    $user->updated_user_id = auth()->id();
                    $user->save();
                    Session::flash('success', 'Sign up Successfully.');
                    return redirect()->route('login');
                } else {
                    return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
                }
            }
            if (!$existingUserByName && !$existingUserByEmail) {
                $user = User::signUpNewUser($request);
                $user->create_user_id = auth()->id();
                $user->updated_user_id = auth()->id();
                $user->save();
                Session::flash('success', 'Sign up Successfully.');
                return redirect()->route('login');
            }
        }   
            else {
                $existingUserByEmail = User::userExistByEmail($request);
                $existingUserByName = User::userExistByName($request);
                if ($existingUserByName) {
                    if ($existingUserByName->deleted_at) {
                        $user = User::signUpExistingUser($request, $existingUserByName);
                        $user->create_user_id = $user->id;
                        $user->updated_user_id = $user->id;
                        $user->save();
                        Session::flash('success', 'Sign up Successfully.');
                        return redirect()->route('login');
                    } else {
                        return redirect()->back()->withErrors(['name' => 'The name has already been taken.'])->withInput();
                    }
                }

                if ($existingUserByEmail) {
                    if ($existingUserByEmail->deleted_at) {
                        $user = User::signUpExistingUser($request, $existingUserByEmail);
                        $user->create_user_id = $user->id;
                        $user->updated_user_id = $user->id;
                        $user->save();
                        Session::flash('success', 'Sign up Successfully.');
                        return redirect()->route('login');
                    } else {
                        return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
                    }
                }
                    if (!$existingUserByName && !$existingUserByEmail) {
                        $user = User::signUpNewUser($request);
                        $user->create_user_id = $user->id;
                        $user->updated_user_id = $user->id;
                        $user->save();
                        Session::flash('success', 'Sign up Successfully.');
                        return redirect()->route('login');
                    }
            }
        
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findUser($id);
        return $user;
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findUser($id);
        if (!Hash::check($request->currentPw, $user->password)) {
            return back()->withErrors(['currentPw' => 'Current password is incorrect'])->withInput();
        }
        $request->validate([
            'newPw' => 'required|min:4',
            'pw_confirmation' => 'same:newPw',
        ], [
            'newPw.required' => 'The password field can\'t be blank.',
            'newPw.min' => 'The password must be at least 4 characters.',
            'pw_confirmation.same' => 'The password confimation field must match the new password field.'
        ]);
        User::updatePassword($request, $user);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('login')->with('success', 'Password updated successfully.')->withInput();
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
            return redirect()->back()->withInput()->with('error', 'Email not found')->withInput();
        }
        $name = $user->name;
        $token = Str::random(64);
        User::addToken($request, $token);
        $data = [
            'token' => $token,
            'email' => $request->email,
            'name' => $name,
        ];
        try {
                Mail::to($request->email)->send(new SendMail($data));
                return redirect()->back()->with('success', 'Email sent with password reset instructions.');
        }  catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No internet');
        }
    }
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);
        $email = $request->session()->get('reset_password_email');

        $user = User::checkToken($request, $email);
        if ($user == null) {
            return $user;
        } else {
            $user = User::updateResetPassword($request, $email);
            return $user;
        }

    }
}