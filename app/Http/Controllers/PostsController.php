<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function adminPostList()
    {
        $posts = Posts::where('deleted_at', null)
        ->where('deleted_user_id', null)
        ->paginate(6);
        return view('posts.post_list', compact('posts'));
    }
    public function userPostList()
    {
        $userId = auth()->id();
        $posts = Posts::where('create_user_id', $userId)
        ->where('deleted_at', null)
        ->where('deleted_user_id', null)
        ->paginate(6);
        return view('posts.post_list', compact('posts'));
    }
    public function searchPost(Request $request)
    {
        if (auth()->user()->type == 'admin') {
            dd($request->all());
            //dd(auth()->user()->type);
            //return redirect()->route('admin.postList');//Go to web.php to route with middleware (compact with user()->type)
        } else {
            $userId = auth()->id();
            $search = strtolower($request->input('search'));
            if ($search != '') {
                $posts = Posts::where(function($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                          ->orWhere('description', 'like', "%$search%");
                })
                ->where('create_user_id', $userId)
                ->where('status', 1)
                ->where('deleted_at', null)
                ->where('deleted_user_id', null)
                ->paginate(6);
                return view('posts.post_list', compact('posts'));
            }
        }
    }

    public function createPost(Request $request)
    {
        return view('posts.create_post');
    }
    public function confirmPost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',

        ]);
        $title = $request->title;
        $description = $request->description;
        $create_user_id = auth()->id();
        $updated_user_id = auth()->id();
        return view('posts.create_confirm_post', compact('title', 'description', 'create_user_id', 'updated_user_id'));
    }
    
    public function postSave(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',

        ]);
        $post = Posts::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'create_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $post->create_user_id = auth()->id();
        $post->updated_user_id = auth()->id();
        $post->save();
        $request->session()->flash('success', 'Post created successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');//Go to web.php to route with middleware (compact with user()->type)
        } else {
            return redirect()->route('user.postList');//Go to web.php to route with middleware
        }
    }
    public function edit(string $id)
    {
        $posts = Posts::findOrFail($id);
        return view('posts.edit_post', compact('posts'));
    }
    public function confirmEdit(\Illuminate\Http\Request $request, $id)
    {
        $post = $request;
        $toggleStatus = $post->toggle_switch;
        return view('posts.edit_confirm_post', compact('post', 'toggleStatus'));
    }

    public function update(Request $request, string $id)
    {
        $post = Posts::findOrFail($id);
        $toggleStatus = $post->toggle_switch;
        if($toggleStatus==1){
            $post->status = 1;
        }
        else{
            $post->status = 0;
        }
        $post->update($request->all());
        $request->session()->flash('success', 'Post updated successfully!');
        if (auth()->user()->type == 'admin') {
             return redirect()->route('admin.postList');
         } else {
            return redirect()->route('user.postList');
         }
    }
    public function uploadCSV(Request $request)
    {
        return view('posts.upload_csv');
    }

}
