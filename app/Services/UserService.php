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
    $users = User::latest()->paginate(8);
    return $users;
  }
  public function userListUser()
  {
    $userId = auth()->user()->id;
    $users = User::where('create_user_id', $userId)
      ->latest()
      ->paginate(8);
    return $users;
  }

  public function deleteUser($request, $id)
  {
    $user = User::findOrFail($id);
    DB::table('users')
      ->where('id', $id)
      ->update(
        array(
          'deleted_user_id' => auth()->user()->id,
          'deleted_at' => Carbon::now()
        )
      );
    $create_user_id = $id;
    $posts = Posts::where('create_user_id', $create_user_id)->get();
    $deleted = Posts::where('create_user_id', $create_user_id)->delete();

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
    $existingUser = User::withTrashed()
      ->where('email', $email)
      ->first();
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
    $existingemail = User::withTrashed()
      ->where('email', $request->email)
      ->first();

    if ($existingemail) {
      if ($existingemail->deleted_at) {
        $existingemail->restore();
        $existingemail->update([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->pw),
          'profile' => $profile,
          'phone' => $request->phone,
          'type' => $request->type,
          'address' => $request->address,
          'dob' => $request->dob,
          'create_user_id' => auth()->user()->id,
          'updated_user_id' => auth()->user()->id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
        Session::flash('create', 'Register Successfully');
      }
    } else {
      if (auth()->user()->type == 'admin') {
        User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->pw),
          'profile' => $profile,
          'type' => $request->type,
          'phone' => $request->phone,
          'address' => $request->address,
          'dob' => $request->dob,
          'create_user_id' => auth()->user()->id,
          'updated_user_id' => auth()->user()->id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
        Session::flash('create', 'Register Successfully.');
      } else {
        User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->pw),
          'profile' => $profile,
          'phone' => $request->phone,
          'address' => $request->address,
          'type' => $request->type,
          'dob' => $request->dob,
          'create_user_id' => auth()->user()->id,
          'updated_user_id' => auth()->user()->id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()

        ]);
        Session::flash('create', 'Register Successfully.');
      }
    }
  }
  public function profile(string $id)
  {
    $user = User::findOrFail($id);
    return $user;
  }

  public function editProfile($id)
  {
    $user = User::findOrFail($id);
    return $user;
  }
  public function updateProfile(Request $request, string $id)
  {
    $user = User::findOrFail($id);
    $newProfile = $request->file('newProfile');
    if ($newProfile) {
      if ($user->profile) {
        Storage::delete($user->profile);
      }
      $user = $request;
      $imageName = time() . '.' . $newProfile->extension();
      $success = $request->newProfile->move(public_path('img'), $imageName);
      $imagePath = 'img/' . $imageName;
      $user = User::findOrFail($id);
      $user->profile = $imagePath;
    }
    $user->update($request->all());
    $request->session()->flash('create', 'User updated successfully!');
  }
  public function searchUser(Request $request)
  {
    if (auth()->user()->type == 'admin') {
      $pageSize = $request->input('pageSize', 8);
      $userId = auth()->id();
      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');
      $end_date_inclusive = Carbon::parse($end_date)->endOfDay();
      $searchName = strtolower($request->input('name'));
      $searchEmail = strtolower($request->input('email'));
      $startDate = Carbon::parse($start_date)->startOfDay();
      $endDate = Carbon::parse($end_date)->endOfDay();
      $usersQuery = User::query();
      if (!empty($searchName)) {
        $usersQuery->where(function ($query) use ($searchName) {
          $query->where('name', 'like', "%$searchName%");
        });
      }
      if (!empty($searchEmail)) {
        $usersQuery->where(function ($query) use ($searchEmail) {
          $query->where('email', 'like', "%$searchEmail%");
        });
      }
      if (!empty($start_date) && !empty($end_date)) {
        $usersQuery->whereBetween('created_at', [$start_date, $end_date_inclusive]);
      } elseif (!empty($start_date)) {
        $usersQuery->whereDate('created_at', '=', $start_date);
      } elseif (!empty($end_date)) {
        $usersQuery->whereDate('created_at', '=', $end_date);
      }
      $users = $usersQuery->whereNull('deleted_at')
        ->latest()
        ->paginate($pageSize);
      return $users;
    } else {
      $pageSize = $request->input('pageSize', 8);
      $userId = auth()->id();
      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');
      $end_date_inclusive = Carbon::parse($end_date)->endOfDay();
      $searchName = strtolower($request->input('name'));
      $searchEmail = strtolower($request->input('email'));
      $startDate = Carbon::parse($start_date)->startOfDay();
      $endDate = Carbon::parse($end_date)->endOfDay();
      $usersQuery = User::query();

      if (!empty($searchName)) {
        $usersQuery->where(function ($query) use ($searchName) {
          $query->where('name', 'like', "%$searchName%");
        });
      }
      if (!empty($searchEmail)) {
        $usersQuery->where(function ($query) use ($searchEmail) {
          $query->where('email', 'like', "%$searchEmail%");
        });
      }
      if (!empty($start_date) && !empty($end_date)) {
        $usersQuery->whereBetween('created_at', [$start_date, $end_date_inclusive]);
      } elseif (!empty($start_date)) {
        $usersQuery->whereDate('created_at', '=', $start_date);
      } elseif (!empty($end_date)) {
        $usersQuery->whereDate('created_at', '=', $end_date);
      }
      $users = $usersQuery->whereNull('deleted_at')
        ->where('create_user_id', $userId)
        ->latest()
        ->paginate($pageSize);
      return $users;
    }
  }
}