<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'create_user_id',
        'updated_user_id',
        'deleted_user_id',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }
    public static function getAllPosts($request)
  {
      $pageSize = $request->input('pageSize', 4); 
      $posts = Posts::where('status', 1)->latest()->paginate($pageSize);
      return $posts;
  }
  public static function getPostList($request)
  {
    if (auth()->user()->type == "admin") {
        $pageSize = $request->input('pageSize',4); 
        $posts = Posts::latest()->paginate($pageSize); 
        $posts->appends(['pageSize' => $pageSize]); 
        return $posts;
    } else{
        $userId = auth()->id();
        $pageSize = $request->input('pageSize', 4); 
        $posts = Posts::where('create_user_id', $userId)->latest()->paginate($pageSize); 
        $posts->appends(['pageSize' => $pageSize]); 
        return $posts;
    }
  }
    public static function creatCSVPost($records)
    {
        foreach ($records as $record) {
            if (count($record) !== 3) {
                //dd("Header is not equal to three");
                //return ['error' => 'Each row in the CSV must have exactly 3 columns.'];
                return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
            }

            //Posts::savePost($records);
            // Create or update posts based on CSV data
            Posts::create([
                'title' => $record['title'],
                'description' => $record['description'],
                'status' => $record['status'],
                'create_user_id' => auth()->id(),
                'updated_user_id' => auth()->id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
    public static function searchPost($request,$pageSize,$search)
    {
        if (auth()->check()) {
            if (auth()->user()->type == 'admin') {
                $pageSize = $request->input('pageSize', 4);
                $search = strtolower($request->input('search'));
                $posts = Posts::where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                    ->latest()
                    ->paginate($pageSize);
                  return $posts;
            } else {
                $pageSize = $request->input('pageSize', 4);
                $userId = auth()->user()->id;
                $search = strtolower($request->input('search'));
                $posts = Posts::where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                    ->where('create_user_id', $userId)
                    ->latest()
                    ->paginate($pageSize);
                    return $posts;
            }
        }
        else{
            $pageSize = $request->input('pageSize', 4);
            $search = strtolower($request->input('search'));
            $posts = Posts::where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })
                ->where('status', 1)
                ->latest()
                ->paginate($pageSize);
                return $posts;
        }
    }
    public static function savePost($request)
    {
        $post = Posts::create([
            'title' => $request->title,
            'description' => $request->description,
            'create_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $post->create_user_id = auth()->id();
        $post->updated_user_id = auth()->id();
        $post->save();
    }
    public static function findPost($id)
    {
        $posts = Posts::findOrFail($id);
        return $posts;
    }
    public static function findByCreateUID()
    {
        $posts = Posts::where('create_user_id', auth()->user()->id)
                ->get();
        return $posts;
    }
    public static function updatePost($post,$request)
    {
        $post->update($request->all());
    }
    public static function deletePost($id)
    {
        $deleted = Posts::destroy($id);
    }
}
