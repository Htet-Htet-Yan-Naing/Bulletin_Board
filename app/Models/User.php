<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'updated_user_id' => auth()->user()->id,
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
    public static function searchByName($searchName, $pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $usersQuery = User::query();
            $usersQuery->where(function ($query) use ($searchName) {
                $query->where('name', 'like', "%$searchName%");
            });
            $users = $usersQuery->whereNull('deleted_at')
                ->latest()
                ->paginate($pageSize);
            return $users;
        } else {
            $usersQuery = User::query();
            $usersQuery->where(function ($query) use ($searchName) {
                $query->where('name', 'like', "%$searchName%");
            });
            $users = $usersQuery->whereNull('deleted_at')
                ->where('create_user_id', auth()->id())
                ->latest()
                ->paginate($pageSize);
            return $users;
        }

    }
    public static function searchByEmail($searchEmail, $pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $usersQuery = User::query();
            if (!empty($searchEmail)) {
                $usersQuery->where(function ($query) use ($searchEmail) {
                    $query->where('email', 'like', "%$searchEmail%");
                });
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->latest()
                ->paginate($pageSize);
            return $users;
        } else {
            $usersQuery = User::query();
            if (!empty($searchEmail)) {
                $usersQuery->where(function ($query) use ($searchEmail) {
                    $query->where('email', 'like', "%$searchEmail%");
                });
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->where('create_user_id', auth()->id())
                ->latest()
                ->paginate($pageSize);
            return $users;
        }

    }

    public static function searchByDateBetween($start_date, $end_date_inclusive, $pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $usersQuery = User::query();
            $usersQuery->whereBetween('created_at', [$start_date, $end_date_inclusive]);
            $users = $usersQuery->whereNull('deleted_at')
                ->latest()
                ->paginate($pageSize);
            return $users;
        } else {
            $usersQuery = User::query();
            $usersQuery->whereBetween('created_at', [$start_date, $end_date_inclusive]);
            $users = $usersQuery->whereNull('deleted_at')
                ->where('create_user_id', auth()->id())
                ->latest()
                ->paginate($pageSize);
            return $users;
        }

    }
    public static function searchByStartDate($start_date, $pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $usersQuery = User::query();
            if (!empty($start_date)) {
                $usersQuery->whereDate('created_at', '=', $start_date);
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->latest()
                ->paginate($pageSize);
            return $users;
        } else {
            $usersQuery = User::query();
            if (!empty($start_date)) {
                $usersQuery->whereDate('created_at', '=', $start_date);
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->where('create_user_id', auth()->id())
                ->latest()
                ->paginate($pageSize);
            return $users;
        }

    }
    public static function searchByEndDate($end_date, $pageSize)
    {
        if (auth()->user()->type == 'admin') {
            $usersQuery = User::query();
            if (!empty($end_date)) {
                $usersQuery->whereDate('created_at', '=', $end_date);
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->latest()
                ->paginate($pageSize);
            return $users;
        }else{
            $usersQuery = User::query();
            if (!empty($end_date)) {
                $usersQuery->whereDate('created_at', '=', $end_date);
            }
            $users = $usersQuery->whereNull('deleted_at')
                ->where('create_user_id', auth()->id())
                ->latest()
                ->paginate($pageSize);
            return $users;
        }
    }
}
