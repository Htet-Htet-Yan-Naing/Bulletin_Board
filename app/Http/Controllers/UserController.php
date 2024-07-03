<?php

namespace App\Http\Controllers;
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
class UserController extends Controller
{
    public function userListAdmin(Request $request)
    {
       $users = User::latest()->paginate(4);
        return view('users.user_list', compact('users'));
    }
    public function userListUser(Request $request)
    {
        $userId = auth()->user()->id;
        $users = User::where('create_user_id', $userId)
            ->latest()
            ->paginate(4);
        return view('users.user_list', compact('users'));
    }

    public function deleteUser(Request $request, $id)
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
        // Find all posts created by the user with the given user_id
        $posts = Posts::where('create_user_id', $create_user_id)->get();
        // Delete all found posts
         $deleted = Posts::where('create_user_id', $create_user_id)->delete();

        $request->session()->flash('create', 'User deleted successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
    }
   
    //public function userList()
    //{
    //    $users = User::Paginate(1);
    //    return view('users.user_list', compact('users'));
    //}
    public function register()
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
            'email.email' => 'Email is invalid',
            'email.unique' => 'The email has already been taken.',
            'profile.required' => 'Profile can\'t be blank.',
            'pw.required' => 'The password field can\'t be blank.',
            'pw.min' => 'The password must be at least 4 characters.',
            'pw.confirmed' => 'Password and password confimation is not match.',
        ]);
        $existingPost = User::withTrashed()
            ->where('name', $request->name)
            ->where('email', $request->email)
            ->first();
        if ($existingPost) {
            if (!$existingPost->deleted_at) {
                return redirect()->back()->withErrors(['title' => 'The email has already been taken.']);
            }
        }
        $user = $request;
        $imageName = time() . '.' . $request->profile->extension();
        $success = $request->profile->move(public_path('img'), $imageName);
        $imagePath = 'img/' . $imageName;
        return view('users.create_user_confirm', compact('user', 'imagePath'));
    }
    public function userSave(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255',
            'pw' => 'required|min:4|confirmed',
            'imagePath' => 'required',
        ], [
            'name.required' => 'Name can\'t be blank.',
            'email.required' => 'Email can\'t be blank.',
            'email.email' => 'Email format is inavalid',
            'email.unique' => 'The email has already been taken.',
            'imagePath.required' => 'Profile can\'t be blank.',
            'pw.required' => 'The password field can\'t be blank.',
            'pw.min' => 'The password must be at least 4 characters.',
            'pw.confirmed' => 'Password and password confimation is not match.',
        ]);
        $existingUser = User::withTrashed()
            ->where('name', $request->name)
            ->where('email', $request->email)
            ->first();
        if ($existingUser) {
            if ($existingUser->deleted_at) {
                $existingUser->name = $validatedData['name'];
                $existingUser->email = $validatedData['email'];
                $existingUser->password = Hash::make($validatedData['pw']);
                $existingUser->phone = $request->input('phone');
                $existingUser->address = $request->input('address');
                $existingUser->dob = $request->input('dob');
                $existingUser->create_user_id = auth()->id();
                $existingUser->updated_user_id = auth()->id();
                $existingUser->deleted_at = null;
                $existingUser->deleted_user_id = null;
                $existingUser->save();
                $request->session()->flash('create', 'User Created successfully!');
            }
        } else {
            $type = $request->type;
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['pw']),
                'dob' => $request->input('dob'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'type' => $type,
                'profile' => $request->input('imagePath'),
                'create_user_id' => 1,
                'updated_user_id' => 1
            ]);
            $user->create_user_id = auth()->id();
            $user->updated_user_id = auth()->id();
            $user->save();
            $request->session()->flash('create', 'User created successfully!');

        }
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.userList');
        } else {
            return redirect()->route('user.userList');
        }
    }

    public function profile(string $id)
    {
        $user = User::findOrFail($id);
        $imageName = $user->profile;
        $imagePath = $imageName;
        return view('users.show_profile', compact('user', 'imagePath'));
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $imageName = $user->profile;
        $imagePath = $imageName;

        return view('users.edit_profile', compact('user', 'imagePath'));
    }
    public function updateProfile(Request $request, string $id)
    {
        // if ($request->hasFile('new-profile')) 
        $user = User::findOrFail($id);
        if ($request->hasFile('newProfile')) {
            dd($request->newProfile);
        }
        //    // Validate the uploaded file
        //    $request->validate([
        //        'new-profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file validation rules as needed
        //    ]);
            $newProfile = $request->newProfile;
            //  dd($newProfile);
            //  Handle profile picture upload
            if ($newProfile) {
                // dd($id);

                if ($user->profile) {
                    Storage::delete($user->profile);
                }
                $user = $request;
                $imageName = time() . '.' . $request->file('newProfile')->extension();
                //$imageName = time() . '.' . $request->file('newProfile')->getClientOriginalExtension();
                $success = $request->profile->move(public_path('img'), $imageName);
                $imagePath = 'img/' . $imageName;
                dd($imagePath);
                $user = User::findOrFail($id);
                $user->profile = $imagePath;
            }
            $user->update($request->all());
            $request->session()->flash('create', 'User updated successfully!');
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.userList');
            } else {
                return redirect()->route('user.userList');
            }
        }



        //    public function updateProfile(Request $request, string $id)
//{
//    $user = User::findOrFail($id);
//    $newProfile=$request->newProfile;
//    //dd($newProfile);
//    // Handle profile picture upload
//    if ($newProfile) {
//        // Delete old profile picture if exists
//        if ($user->profile) {
//                
//            Storage::delete($user->profile);
//        }
//        
//        // Move new profile picture to public/img directory
//        $imageName = time() . '.' . $request->file('new-profile')->getClientOriginalExtension();
//        $request->file('new-profile')->move(public_path('img'), $imageName);
//        $imagePath = 'img/' . $imageName;
//
//        // Update user's profile field in database
//        $user->profile = $imagePath;
//    }
//
//    // Update other user details
//    $user->update($request->except('new-profile'));
//
//    // Flash message
//    $request->session()->flash('create', 'User updated successfully!');
//
//    // Redirect based on user type
//    if (auth()->user()->type == 'admin') {
//        return redirect()->route('admin.userList');
//    } else {
//        return redirect()->route('user.userList');
//    }
//}
//  
    
    public function searchUser(Request $request)
    {
        if (auth()->user()->type == 'admin') {
            $pageSize = $request->input('pageSize', 4);
            $userId = auth()->id();
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $end_date_inclusive = Carbon::parse($end_date)->endOfDay();
            $searchName = strtolower($request->input('name'));
            $searchEmail = strtolower($request->input('email'));
            $startDate = Carbon::parse($start_date)->startOfDay();
            $endDate = Carbon::parse($end_date)->endOfDay();
            $usersQuery = User::query();
            //if(empty($searchName) && empty($searchEmail) && empty($start_date) && empty($end_date)) {
            //    return back()->withErrors(['name' => 'Enter name to search','email'=> 'Enter name to search',
            //    'start_date'=> 'Select start date','end_date'=> 'Select end date']);
            //}
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
            $usersQuery->whereBetween('created_at', [$start_date,$end_date_inclusive]);
        } elseif (!empty($start_date)) {
            $usersQuery->whereDate('created_at', '=', $start_date);
        } elseif (!empty($end_date)) {
            $usersQuery->whereDate('created_at', '=', $end_date);
        }
            $users = $usersQuery->whereNull('deleted_at')
                    ->latest()
                    ->paginate($pageSize);
                return view('users.user_list', compact('users'));
        } 

        else {
            $pageSize = $request->input('pageSize', 4);
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
            $usersQuery->whereBetween('created_at', [$start_date,$end_date_inclusive]);
        } elseif (!empty($start_date)) {
            $usersQuery->whereDate('created_at', '=', $start_date);
        } elseif (!empty($end_date)) {
            $usersQuery->whereDate('created_at', '=', $end_date);
        }
        $users = $usersQuery->whereNull('deleted_at')
                    ->where('create_user_id', $userId)
                    ->latest()
                    ->paginate($pageSize);
                return view('users.user_list', compact('users'));
            }
        }
    }

