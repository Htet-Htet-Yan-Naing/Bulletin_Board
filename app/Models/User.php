<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'profile',
        'type',
        'phone',
        'address',
        'dob',
        'create_user_id',
        'updated_user_id',
        'deleted_user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function posts()
    {
        return $this->hasMany(Posts::class, 'create_user_id', 'id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["admin", "user"][$value],
        );
    }
    public static function getUserListAdmin()
    {
        $users = User::latest()->paginate(8);
        return $users;
    }
    public static function getUserListUser()
    {
        $userId = auth()->user()->id;
        $users = User::where('create_user_id', $userId)
            ->latest()
            ->paginate(8);
        return $users;
    }
    public static function deleteUser($request, $id)
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
    }
    public static function userExist($request)
    {
        $email = $request->email;
        $name = $request->name;
        $existingUser = User::withTrashed()
            ->where('email', $email)
            ->orWhere('name', $name)
            ->first();
        return $existingUser;
    }
    public static function saveUser($request, $profile)
    {
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
            'updated_user_id'=> auth()->user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
    public static function saveExistingUser($existingemail, $request, $profile)
    {
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
    }
    public static function signUpExistingUser($request, $existinguser)
    {
        $existinguser->restore();
        $existinguser->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->pw),
            'type' => "1",
            'create_user_id' => 1,
            'updated_user_id' => 1
        ]);
        return $existinguser;
    }
    public static function signUpNewUser($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->pw),
            'type' => "1",
            'create_user_id' => 1,
            'updated_user_id' => 1
        ]);
        return $user;
    }
    public static function findUser($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }
    public static function updateProfile($request, $user)
    {
        $user->update($request->all());
    }

    public static function searchUser($pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $users = User::latest()->paginate($pageSize);
            return $users;
        } else {
            $userId = auth()->user()->id;
            $users = User::where('create_user_id', $userId)
                ->latest()
                ->paginate($pageSize);
            return $users;
        }

    }
    public static function searchFilter($pageSize, $name, $email, $start_date, $end_date)
    {
        if (auth()->user()->type == 'admin') {
            $users = User::
                whereNull('deleted_at')
                ->when($name, function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($email, function ($query) use ($email) {
                    return $query->where('email', 'like', '%' . $email . '%');
                })
                ->when($start_date, function ($query) use ($start_date) {
                    return $query->whereDate('created_at', '>=', $start_date);
                })
                ->when($end_date, function ($query) use ($end_date) {
                    return $query->whereDate('created_at', '<=', $end_date);
                })->paginate($pageSize);
            return $users;
        } else {
            $users = User::where('create_user_id', auth()->id())
                ->whereNull('deleted_at')->when($name, function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($email, function ($query) use ($email) {
                    return $query->where('email', 'like', '%' . $email . '%');
                })
                ->when($start_date, function ($query) use ($start_date) {
                    return $query->whereDate('created_at', '>=', $start_date);
                })
                ->when($end_date, function ($query) use ($end_date) {
                    return $query->whereDate('created_at', '<=', $end_date);
                })->paginate($pageSize);
            return $users;
        }
    }

    public static function updatePassword($request, $user)
    {
        $newPw = Hash::make($request->newPw);
        //$newConfirmPw = Hash::make($request->pw_confirmation);
        $user->password = $newPw;
        $user->save();
    }

    public static function addToken($request, $token)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);
    }

    public static function checkToken($request,$email)
    {
        $updatePassword = DB::table('password_reset_tokens')
                            ->where([
                              'email' =>  $email, 
                              'token' => $request->token
                            ])
                            ->first();
        return $updatePassword;
    }

    public static function updateResetPassword($request,$email)
    {
        $user = User::where('email', $email)
        ->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email'=> $email])->delete();
        return $user;
    }

}
