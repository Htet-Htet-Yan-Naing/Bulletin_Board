<?php
namespace App\Http\Controllers;
use App\Services\AuthService;
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
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }
    public function signup()
    {
        return view("auth/signup");
    }
    public function signupSave(Request $request)
    {
        $this->authService->signupSave($request);
        return redirect()->route('login');
    }
  
    public function login()
    {
        return view('auth/login');
    }

    //Login action
    public function loginAction(Request $request)
    {
        $user=$this->authService->loginAction($request);
       if($user){
           // dd($user->email);
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                //'email' => trans('auth.failed')
                return redirect()->back()->with('success', 'Incorrect password');
        }
        //$request->session()->regenerate();
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
        //if (Auth::attempt($request->only('email', 'password'))){
        //   // dd($user->password);
        //    $request->session()->regenerate();
        //    if (auth()->user()->type == 'admin') {
        //        return redirect()->route('admin.postList');
        //    } else {
        //        return redirect()->route('user.postList');
        //    }
        }
    //    else{
    //        return redirect()->back()->with('success', 'Incorrect password');
    //   }
    //}
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
        $user=$this->authService->changePassword($request,$id);
        return view('auth.change_password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $this->authService->updatePassword($request,$id);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
       
    }
    public function showForgetPasswordForm(Request $request)
    {
        return view('auth.forgetPassword');
    }
    public function submitForgetPasswordForm(Request $request)
    {
        $this->authService->submitForgetPasswordForm($request);
        return back()->with('success', 'Email sent with password reset instructions.');
    }
    public function showResetPasswordForm(Request $request,$token)
    {
        return view('auth.resetPassword',  ['token' => $token]);
    }
   
    public function submitResetPasswordForm(Request $request)
    {
        $this->authService->submitResetPasswordForm($request);
        return redirect()->route('login')->with('success', 'Password has been reset');
    }
}
