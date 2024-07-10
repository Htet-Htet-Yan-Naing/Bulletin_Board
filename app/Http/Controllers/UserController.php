<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function userListAdmin(UserService $userService)
    {
        $users = $this->userService->userListAdmin();
        return view('users.user_list', compact('users'));
    }


    public function userListUser()
    {
        $users = $this->userService->userListUser();
        return view('users.user_list', compact('users'));
    }


    public function deleteUser(Request $request, $id)
    {
        $this->userService->deleteUser($request, $id);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
    }


    public function register(Request $request)
    {
        return view('users.create_user');
    }
    public function confirmRegister(Request $request)
    {
        return $this->userService->confirmRegister($request);
    }

    public function userSave(Request $request)
    {
        $this->userService->userSave($request);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
    }

    public function profile(string $id)
    {
        $user = $this->userService->profile($id);
        $imageName = $user->profile;
        $imagePath = $imageName;
        return view('users.show_profile', compact('user', 'imagePath'));
    }

    public function editProfile(Request $request, $id)
    {
        $user = $this->userService->editProfile($id);
        $imageName = $user->profile;
        $imagePath = $imageName;
        return view('users.edit_profile', compact('user', 'imagePath'));
    }

    public function updateProfile(Request $request, string $id)
    {
        $this->userService->updateProfile($request, $id);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
    }
    public function searchUser(Request $request)
    {
        $users = $this->userService->searchUser($request);
        return view('users.user_list', compact('users'));
    }
}

