<?php

namespace App\Http\Controllers;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function adminPostList()
    {
        $posts = Posts::Paginate(6);
        return view('posts.post_list', compact('posts'));
    }
    public function userPostList()
    {    
    $userId = auth()->id();
    $posts = Posts::where('create_user_id', $userId)->paginate(6);
    // $posts = Posts::Paginate(6);
    return view('posts.post_list', compact('posts'));
    }
    public function createPost()
    {
        
        return view('posts.create_post');
    }
    public function confirmPost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ], [
                'title.required' => 'The title field can\'t be blank.',
                'description.required' => 'The description field can\'t be blank.',
                'title.max' => '255 characters is the maximum allowed',
               
        ]);
        $title = $request->title;
        $description = $request->description;
        $create_user_id=auth()->id();
       // dd($create_user_id);
        $updated_user_id=auth()->id();
       // dd($updated_user_id);
        return view('posts.create_confirm_post', compact('title', 'description','create_user_id','updated_user_id'));
    }
    // public function store(\Illuminate\Http\Request $request)
    // {
    //     Posts::create($request->all());
    //     $request->session()->flash('success', 'Post created successfully!');
    //     return redirect()->route('posts.postList');
    // }
    public function postSave(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ], [
                'title.required' => 'The title field can\'t be blank.',
                'description.required' => 'The description field can\'t be blank.',
                'title.max' => '255 characters is the maximum allowed',
               
        ]);
        $post= Posts::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'create_user_id'=>9,
            'updated_user_id'=>9
        ]);
             $post->create_user_id = auth()->id();
             $post->updated_user_id =auth()->id();
             $post->save();
             $request->session()->flash('success', 'Post created successfully!');
              
        if (auth()->user()->type == 'admin') {
           //dd(auth()->user()->type);
            return redirect()->route('admin.postList');//Go to web.php to route with middleware (compact with user()->type)
        } else {
           //dd(auth()->user()->type);
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
        $post->update($request->all());
        $request->session()->flash('success', 'Post updated successfully!');
        return redirect()->route('posts.postList');
    }
    public function uploadCSV(Request $request)
    {
        return view('posts.upload_csv');
    }

}
