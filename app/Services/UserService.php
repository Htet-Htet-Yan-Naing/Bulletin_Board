<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    
    $existingUserByEmail = User::userExistByEmail($request);
    $existingUserByName = User::userExistByName($request);

    if ($existingUserByName) {
      if ($existingUserByName->deleted_at) {
        if ($request->hasFile('profile')) {
          $file = $request->file('profile');
          $user = $request;
        }
      } else {
        return redirect()->back()->withErrors(['name' => 'The name has already been taken.'])->withInput();
      }
    }

      if ($existingUserByEmail) {
        if ($existingUserByEmail->deleted_at) {
          if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $user = $request;
          } 
        }else {
          return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        }
      }
        if ($request->hasFile('profile')) {
          $fileName = time() . '.' . $request->file('profile')->getClientOriginalExtension();
          $request->profile->move(public_path('img'), $fileName);
          Session::put('profile', 'img/' . $fileName);
        }
        $user = $request;
        return view('users.create_user_confirm', compact('user'));
  }
  public function userSave(Request $request)
  {
    $profile = Session::get('profile');
    $existingemail = User::userExistByEmail($request);
    $existingname = User::userExistByName($request);
    if ($existingemail||$existingname) {
      if ($existingemail) {
        if ($existingemail->deleted_at) {
          User::saveExistingUser($existingemail, $request, $profile);
        } else {
          return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        }
      }
      if ($existingname) {
        if ($existingname->deleted_at) {
          User::saveExistingUser($existingname, $request, $profile);
        } else {
          return redirect()->back()->withErrors(['name' => 'The name has already been taken.'])->withInput();
        }
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
    if ($user->type == 'admin') {
      return redirect()->route('admin.userList');
  } else {
      return redirect()->route('user.userList');
  }
  }
  public function searchUser(Request $request)
  {
      $pageSize = $request->input('pageSize', 8);
      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');
      $name = strtolower($request->input('name'));
      $email = strtolower($request->input('email'));
      $users=User::searchFilter($pageSize,$name,$email,$start_date,$end_date,$request);
      return $users;
  }
}