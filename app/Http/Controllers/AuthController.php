<?php
namespace App\Http\Controllers;
use App\Services\AuthService;
use AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return $this->authService->signupSave($request);
    }

    public function login()
    {
        return view('auth/login');
    }
    public function loginAction(Request $request)
    {
        $user = $this->authService->loginAction($request);
        if ($user) {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return redirect()->back()->with('error', 'Incorrect password')->withInput();
            }
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.postList');
            } else {
                return redirect()->route('user.postList');
            }
            

        } else {
            return redirect()->back()->with('error', 'Email  does\'t exit.')->withInput();
        }
        //return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function changePassword(Request $request, $id)
    {
        $user = $this->authService->changePassword($request, $id);
        return view('auth.change_password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        return $this->authService->updatePassword($request, $id);
    }
    public function showForgetPasswordForm(Request $request)
    {
        return view('auth.forgetPassword');
    }
    public function submitForgetPasswordForm(Request $request)
    {
        $user = $this->authService->submitForgetPasswordForm($request);
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email not found')->withInput();
        } else {
            return redirect()->back()->with('success', 'Email sent with password reset instructions.');
        }
    }
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $user = $this->authService->submitResetPasswordForm($request);
        if ($user==null) {
            return redirect()->back()->with('error', 'Invalid token!')->withInput();
        } else {
            return redirect()->route('login')->with('success', 'Password has been reset');
        }
    }
}
