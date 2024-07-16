<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Posts;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;

    }
    public function posts(Request $request)
    {
        $posts = $this->postService->posts($request);
        return view('posts.post_list', compact('posts'));
    }
    public function postlist(Request $request)
    {
        $posts = $this->postService->postlist($request);
        $pageSize = $posts->links();
        return view('posts.post_list', compact('posts', 'pageSize'));
    }

    public function searchPost(Request $request)
    {
        $posts = $this->postService->searchPost($request);
        return view('posts.post_list', compact('posts'));
    }

    public function createPost(Request $request)
    {
        return view('posts.create_post');
    }
    public function confirmPost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255|unique:posts',
            'description' => 'required|max:255',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'title.unique' => 'The title has already been taken.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',
            'description.max' => '255 characters is the maximum allowed'
        ]);
        $title = $request->title;
        $description = $request->description;
        $create_user_id = auth()->id();
        $updated_user_id = auth()->id();
        return view('posts.create_confirm_post', compact('title', 'description', 'create_user_id', 'updated_user_id'));
    }

    public function postSave(Request $request)
    {
        $this->postService->postSave($request);
        if (auth()->user()->type == 'admin') {
           
            return redirect()->route('admin.postList');
           
        } else {
            return redirect()->route('user.postList');
        }
        
    }
    public function edit(string $id)
    {
        $posts = $this->postService->edit($id);
        return view('posts.edit_post', compact('posts'));
    }
    public function confirmEdit(Request $request, $id)
    {
        return $this->postService->confirmEdit($request, $id);
    }

    public function update(Request $request, string $id)
    {
        $this->postService->update($request, $id);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }
    public function destroy(Request $request, $id)
    {
        $this->postService->destroy($request, $id);
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }

    public function download(Request $request)
    {
        return $this->postService->download($request);
    }
    public function upload(Request $request)
    {
        return view('posts.upload_csv');
    }
    public function uploadCSV(Request $request)
    {
        return $this->postService->uploadCSV($request);
    }
}
