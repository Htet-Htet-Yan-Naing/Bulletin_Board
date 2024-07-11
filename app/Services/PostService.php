<?php
namespace App\Services;

use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Reader;
use Exception;

class PostService
{
    public function posts(Request $request)
    {
        $posts = Posts::getAllPosts($request);
        return $posts;
    }
    public function postlist(Request $request)
    {
        $posts = Posts::getPostList($request);
        return $posts;
    }

    public function searchPost($request)
    {
        $pageSize = $request->input('pageSize', 4);
        $search = strtolower($request->input('search'));
        $posts = Posts::searchPost($request, $pageSize, $search);
        return $posts;
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
        Posts::savePost($request);
        $request->session()->flash('create', 'Post created successfully!');
    }
    public function edit(string $id)
    {
        $posts=Posts::findPost($id);
        return $posts;
    }
    public function confirmEdit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',
            'description.max' => '255 characters is the maximum allowed'
        ]);
        $post = $request;
        $toggleStatus = $post->toggle_switch;
        $request->session()->flash('toggleStatus', $toggleStatus);
        return view('posts.edit_confirm_post', compact('post', 'toggleStatus'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',
            'description.max' => '255 characters is the maximum allowed'
        ]);
        $post=Posts::findPost($id);
        $toggleStatus = $request->session()->get('toggleStatus');
        $request->session()->put('toggleStatus', $toggleStatus);
        $toggleStatus = $request->toggleStatus;
        if ($toggleStatus == 1) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }
        Posts::updatePost($post,$request);
        $request->session()->flash('create', 'Post updated successfully!');
    }
    public function destroy(Request $request, $id)
    {
        $post = Posts::findPost($id);
        Posts::deletePost($id);
        $request->session()->flash('create', 'Post deleted successfully!');
    }

    public function download(Request $request)
    {
        $pageSize = $request->input('pageSize', 4);
        if (auth()->user()->type == "admin") {
            $search = $request->input('search');
            if ($search) {
                $posts = Posts::searchPost($request,$pageSize,$search);
                return new StreamedResponse(function () use ($posts) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['id', 'title', 'description', 'status', 'create_user_id','updated_user_id','deleted_user_id','deleted_at', 'created_at','updated_at']);
                    foreach ($posts as $post) {
                        fputcsv($handle, [$post->id, $post->title, $post->description,$post->status, $post->create_user_id,$post->updated_user_id, $post->deleted_user_id, $post->deleted_at,$post->created_at, $post->updated_at]);
                    }
                    fclose($handle);
                }, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="posts.csv"',
                ]);
            }
            $posts = Posts::get();
            return new StreamedResponse(function () use ($posts) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['id', 'title', 'description', 'status', 'create_user_id','updated_user_id','deleted_user_id','deleted_at', 'created_at','updated_at']);
                foreach ($posts as $post) {
                    fputcsv($handle, [$post->id, $post->title, $post->description,$post->status, $post->create_user_id,$post->updated_user_id, $post->deleted_user_id, $post->deleted_at,$post->created_at, $post->updated_at]);
                }
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="posts.csv"',
            ]);
        } else {
            $search = $request->input('search');
            if ($search) {
                $posts = Posts::searchPost($request,$pageSize,$search);
                return new StreamedResponse(function () use ($posts) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['id', 'title', 'description', 'status', 'create_user_id','updated_user_id','deleted_user_id','deleted_at', 'created_at','updated_at']);
                    foreach ($posts as $post) {
                        fputcsv($handle, [$post->id, $post->title, $post->description,$post->status, $post->create_user_id,$post->updated_user_id, $post->deleted_user_id, $post->deleted_at,$post->created_at, $post->updated_at]);
                    }
                    fclose($handle);
                }, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="posts.csv"',
                ]);

            }
            $posts = Posts::findByCreateUID();
            return new StreamedResponse(function () use ($posts) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['id', 'title', 'description', 'status', 'create_user_id','updated_user_id','deleted_user_id','deleted_at', 'created_at','updated_at']);
                foreach ($posts as $post) {
                    fputcsv($handle, [$post->id, $post->title, $post->description,$post->status, $post->create_user_id,$post->updated_user_id, $post->deleted_user_id, $post->deleted_at,$post->created_at, $post->updated_at]);
                }
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="posts.csv"',
            ]);
        }
    }
    public function upload(Request $request)
    {

        return view('posts.upload_csv');
    }
    public function uploadCSV(Request $request)
    {
        $file = $request->file('csvfile');
        if ($file == "") {
            return redirect()->back()->with('error', 'Enter file')->withInput();
        }
        $tempPath = sys_get_temp_dir() . '/' . uniqid() . 'csv';


        $file_type = $request->file('csvfile')->getClientOriginalExtension();


        if ($file_type !== 'csv') {
            return redirect()->back()->with('error', 'File must be csv type')->withInput();
        }

        try {
            $file->move(sys_get_temp_dir(), $tempPath);
            $csv = Reader::createFromPath($tempPath, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();
            foreach ($records as $record) {
                if (count($record) !== 3) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                }
                $existingPost = Posts::where('title', $record['title'])->first();
                if ($existingPost) {
                   return redirect()->back()->with('error', 'Post title already exists:'. $record['title'])->withInput();

                }
            }
            Posts::creatCSVPost($records);
            $request->session()->flash('create', 'CSV data uploaded successfully.');
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.postList');
            } else {
                return redirect()->route('user.postList');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
        }
    }

}