<?php
namespace App\Services;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
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

class UserService
{
  public function userListAdmin()
  {
    return User::getUserListAdmin();
  }
  public function userListUser()
  {
    return User::getUserListUser();
  }

  public function deleteUser($request, $id)
  {
    User::deleteUser($request, $id);
    $request->session()->flash('create', 'User deleted successfully!');
  }
  public function register(Request $request)
  {
    return view('users.create_user');
  }
  public function confirmRegister(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|string',
      'email' => 'required|email|max:255',
      'pw' => 'required|min:4|confirmed',
      'profile' => 'required',
    ], [
      'name.required' => 'Name can\'t be blank.',
      'email.required' => 'Email can\'t be blank.',
      'email.email' => 'Email format is invalid',
      'email.unique' => 'The email has already been taken.',
      'name.unique' => 'The name has already been taken.',
      'pw.required' => 'The password field can\'t be blank.',
      'pw.min' => 'The password must be at least 4 characters.',
      'pw.confirmed' => 'Password confirmation does not match.',
      'profile.required' => 'Profile image is required.',
    ]);
    
    $email = $request->email;
    $name = $request->name;
    $existingUser = User::userExist($request);
    if ($existingUser) {
      if ($existingUser->deleted_at) {
        if ($request->hasFile('profile')) {
          $file = $request->file('profile');
          $fileName = time() . '.' . $file->extension();
          $file->move(public_path('img'), $fileName);
          Session::put('profile', 'img/' . $fileName);
        }
      $user = $request;
      return view('users.create_user_confirm', compact('user'));
      }
      else{
        return redirect()->back()->withErrors(['email' => 'The email has already been taken.']);
      }
    }
    if ($request->hasFile('profile')) {
          $file = $request->file('profile');
          $fileName = time() . '.' . $file->extension();
          $file->move(public_path('img'), $fileName);
          Session::put('profile', 'img/' . $fileName);
        }
    $user = $request;
    return view('users.create_user_confirm', compact('user'));
  }

  public function userSave(Request $request)
  {
    $profile = Session::get('profile');
    $existingemail = User::userExist($request);
    if ($existingemail) {
      if ($existingemail->deleted_at) {
        User::saveExistingUser($existingemail,$request,$profile);
        Session::flash('create', 'Register Successfully');
      }
    } else {
      if (auth()->user()->type == 'admin') {
        User::saveUser($request, $profile);
        Session::flash('create', 'Register Successfully.');
      } else {
        User::saveUser($request, $profile);
        Session::flash('create', 'Register Successfully.');
      }
    }
  }
  public function profile(string $id)
  {
    $user = User::findUser($id);
    return $user;
  }

  public function editProfile($id)
  {
    $user = User::findUser($id);
    return $user;
  }
  public function updateProfile(Request $request, string $id)
  {
    $user = User::findUser($id);
    $newProfile = $request->file('newProfile');
    if ($newProfile) {
      if ($user->profile) {
        Storage::delete($user->profile);
      }
      $user = $request;
      $imageName = time() . '.' . $newProfile->extension();
      $success = $request->newProfile->move(public_path('img'), $imageName);
      $imagePath = 'img/' . $imageName;
      $user = User::findUser($id);
      $user->profile = $imagePath;
    }
    User::updateProfile($request,$user);
    $request->session()->flash('create', 'User updated successfully!');
  }
  public function searchUser(Request $request)
  {
      $pageSize = $request->input('pageSize', 8);
      $users = User::searchUser($pageSize);
      $userId = auth()->id();
      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');
      $end_date_inclusive = Carbon::parse($end_date)->endOfDay();
      $searchName = strtolower($request->input('name'));
      $searchEmail = strtolower($request->input('email'));
      if (!empty($searchName)) {
        $users=User::searchByName($searchName,$pageSize);
        return $users;
      }
      if (!empty($searchEmail)) {
        $users=User::searchByEmail($searchEmail,$pageSize);
        return $users;
      }
      if (!empty($start_date) && !empty($end_date)) {
        $users=User::searchByDateBetween($start_date,$end_date_inclusive,$pageSize);
        return $users;
      } elseif (!empty($start_date)) {
        $users=User::searchByStartDate($start_date,$pageSize);
        return $users;
      } elseif (!empty($end_date)) {
        $users=User::searchByEndDate($end_date,$pageSize);
        return $users;
      }
      return $users;
  }
}