<?php

namespace App\Http\Controllers;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function postList()
    {
        $posts= Posts::Paginate(6);
        return view('posts.post_list',compact('posts'));
    }
    public function createPost()
    {
        return view('posts.create_post');
    }
    public function confirmPost(\Illuminate\Http\Request $request)
    {
        $title = $request->title;
        $description=$request->description;
      
        return view('posts.create_confirm_post',compact('title','description'));
    }
    public function store(\Illuminate\Http\Request $request)
    {
        Posts::create($request->all());
        $request->session()->flash('success', 'Post created successfully!');   
        return redirect()->route('posts.postList');  
    }
    public function edit(string $id)
    {
       
        $posts = Posts::findOrFail($id);
        return view('posts.edit_post', compact('posts'));
    }
    public function confirmEdit(\Illuminate\Http\Request $request,$id)
    {
        $post = $request;
        //$title = $request->title;
        //$description=$request->description;
        $toggleStatus=$request->toggle_switch;
        //return view('posts.edit_confirm_post',compact('title','description','toggleStatus'));
        return view('posts.edit_confirm_post',compact('post','toggleStatus'));
    }

    public function update(Request $request, string $id)
    {
        $post = Posts::findOrFail($id);
        $post->update($request->all());
        $request->session()->flash('success', 'Post updated successfully!');   
        return redirect()->route('posts.postList');
    }

}
