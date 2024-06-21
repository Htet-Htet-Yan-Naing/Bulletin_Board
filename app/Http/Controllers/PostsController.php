<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Exports\PostsExport;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use Exception;

class PostsController extends Controller
{
    public function adminPostList()
    {
        $posts = Posts::where('deleted_at', null)
            ->latest()
            ->paginate(6);
        return view('posts.post_list', compact('posts'));
    }
    public function userPostList()
    {
        $userId = auth()->id();
        $posts = Posts::where('create_user_id', $userId)
            ->where('deleted_at', null)
            ->latest()
            ->paginate(6);
        return view('posts.post_list', compact('posts'));
    }

    public function createPost(Request $request)
    {
        return view('posts.create_post');
    }
    public function confirmPost(Request $request)
    {
        $validatedData = $request->validate(
            [
                'title' => 'required|max:255',
                'description' => 'required|max:255',
            ],
            [
                'title.required' => 'The title field can\'t be blank.',
                'title.unique' => 'The title has already been taken.',
                'description.required' => 'The description field can\'t be blank.',
                'title.max' => '255 characters is the maximum allowed',
                'description.max' => '255 characters is the maximum allowed',
            ]
        );
        $existingPost = Posts::withTrashed()
            ->where('title', $request->title)
            ->first();
        if ($existingPost) {
            if (!$existingPost->deleted_at) {
                return redirect()->back()->withErrors(['title' => 'The title has already been taken.']);
            }
        }
        $title = $request->title;
        $description = $request->description;
        $create_user_id = auth()->id();
        $updated_user_id = auth()->id();
        return view('posts.create_confirm_post', compact('title', 'description', 'create_user_id', 'updated_user_id'));
    }

    public function postSave(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ], [
            'title.required' => 'The title field can\'t be blank.',
            'title.unique' => 'The title has already been taken.',
            'description.required' => 'The description field can\'t be blank.',
            'title.max' => '255 characters is the maximum allowed',
            'description.max' => '255 characters is the maximum allowed'
        ]);
        $existingPost = Posts::withTrashed()
            ->where('title', $request->title)
            ->first();
        if ($existingPost) {
            if ($existingPost->deleted_at) {
                $existingPost->title = $validatedData['title'];
                $existingPost->description = $validatedData['description'];
                $existingPost->create_user_id = auth()->id();
                $existingPost->updated_user_id = auth()->id();
                $existingPost->deleted_at = null;
                $existingPost->save();
                $request->session()->flash('success', 'Post updated successfully!');
            }
        } else {
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

        }
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
        if ($toggleStatus == 1) {
            $post->status = 1;
        } else {
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
    public function destroy(Request $request, $id)
    {
        $post = Posts::findOrFail($id);
        DB::table('posts')
            ->where('id', $id)
            ->update(
                array(
                    'deleted_user_id' => auth()->user()->id,
                    'deleted_at' => \Carbon\Carbon::now()
                )
            );
        $request->session()->flash('success', 'Post deleted successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }
    public function searchPost(Request $request)
    {
        $validatedData = $request->validate(
            [
                'search' => 'required',
            ],
            [
                'search.required' => 'Type somthing to search',
            ]
        );
        if (auth()->user()->type == 'admin') {
            $userId = auth()->id();
            $search = strtolower($request->input('search'));
            if ($search != '') {
                $posts = Posts::where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                    ->where('deleted_at', null)
                    ->paginate(6);
                return view('posts.post_list', compact('posts'));
            }
        } else {
            $userId = auth()->id();
            $search = strtolower($request->input('search'));
            if ($search != '') {
                $posts = Posts::where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                    ->where('create_user_id', $userId)
                    ->where('deleted_at', null)
                    ->paginate(6);
                return view('posts.post_list', compact('posts'));
            }
        }
    }

    public function download(Request $request)
    {
        if (auth()->user()->type == 'admin') {
            return Excel::download(new PostsExport, 'posts.csv', \Maatwebsite\Excel\Excel::CSV);
        } elseif (auth()->user()->type == 'user') {
            $search = $request->input('search');
            $posts = Posts::where('title', 'like', '%' . $search . '%')
                ->where('create_user_id', auth()->user()->id)
                ->orWhere('description', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('create_user_id', auth()->user()->id)
                ->paginate(5);

            return new StreamedResponse(function () use ($posts) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Post Title', 'Post Description', 'Posted User', 'Posted Date']);
                foreach ($posts as $post) {
                    fputcsv($handle, [$post->id, $post->title, $post->description, $post->user->type, $post->created_at]);
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
        $validator = Validator::make($request->all(), [
            'csvfile' => 'required|file',
        ]);
        $file_type = $request->file('csvfile')->getClientOriginalExtension();
        if ($file_type !== 'csv') {
            return redirect()->back()->with('error', 'File must be csv type.')->withInput();
        }
        // Retrieve the uploaded file
        $file = $request->file('csvfile');
        try {
            // Parse the CSV file using league/csv
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0); // Set the header offset

            // Get the header and check its length
            $header = $csv->getHeader();

            // Check if the header has exactly 3 columns
            if (count($header) !== 3) {
                dd($header);
                return redirect()->back()->with('error', 'CSV must have exactly 3 columns.')->withInput();
            }

            // Get the records
            $records = Statement::create()->process($csv);

            // Validate each row
            foreach ($records as $record) {
                if (count($record) !== 3) {
                    dd("Not equal to 3");
                    return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                }

                // Create a new postlist entry
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

            return redirect()->route('user.postList')->with('success', 'CSV data uploaded successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
        }
    }

}

