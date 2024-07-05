<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Posts;
use App\Exports\PostsExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use Exception;


class PostsController extends Controller
{
    public function posts(Request $request)
    {
        $pageSize = $request->input('pageSize', 4); 
        $posts = Posts::where('status', 1)->latest()->paginate($pageSize);
        return view('posts.post_list', compact('posts'));
    }
    public function postlist(Request $request)
    {
        if (auth()->user()->type == "admin") {
            $pageSize = $request->input('pageSize',4); 
            $posts = Posts::latest()->paginate($pageSize); 
            $posts->appends(['pageSize' => $pageSize]); 
            return view('posts.post_list', compact('posts','pageSize'));
        } else{
            $userId = auth()->id();
            $pageSize = $request->input('pageSize', 4); 
            $posts = Posts::where('create_user_id', $userId)->latest()->paginate($pageSize); 
            $posts->appends(['pageSize' => $pageSize]); 
            return view('posts.post_list', compact('posts','pageSize'));
        }
    }

    public function searchPost(Request $request)
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
                return view('posts.post_list', compact('posts'));
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
                return view('posts.post_list', compact('posts'));
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
            
            return view('posts.post_list', compact('posts'));
        }
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
        $post = Posts::create([
            'title' => $request->title,
            'description' => $request->description,
            'create_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $post->create_user_id = auth()->id();
        $post->updated_user_id = auth()->id();
        $post->save();
       $request->session()->flash('create', 'Post created successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }
    public function edit(string $id)
    {
        
        $posts = Posts::findOrFail($id);
        return view('posts.edit_post', compact('posts'));
    }
    public function confirmEdit(Request $request, $id)
    {
        $post = $request;
        $toggleStatus = $post->toggle_switch;
        $request->session()->flash('toggleStatus', $toggleStatus);
        return view('posts.edit_confirm_post', compact('post', 'toggleStatus'));
    }

    public function update(Request $request, string $id)
    {
        $post = Posts::findOrFail($id);
        //$toggleStatus = $post->toggle_switch;
        $toggleStatus =  $request->session()->get('toggleStatus');
        $request->session()->put('toggleStatus', $toggleStatus);
       // $toggleStatus = $request->session()->get('toggleStatus');
       $toggleStatus = $request->toggleStatus;
        //dd($toggleStatus);
        if ($toggleStatus == 1) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }
        $post->update($request->all());
        $request->session()->flash('create', 'Post updated successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }
    public function destroy(Request $request, $id)
    {
        $post = Posts::findOrFail($id);
        $deleted = Posts::destroy($id);
        $request->session()->flash('create', 'Post deleted successfully!');
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.postList');
        } else {
            return redirect()->route('user.postList');
        }
    }
   
    public function download(Request $request)
    {
        if(auth()->user()->type == "admin")
        {  
            $search = $request->input('search');
            if($search){
                $posts = Posts::where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->get();
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
            $posts = Posts::get();
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
        else{
            $search = $request->input('search');
            if($search){
                $posts = Posts::where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                })
                    ->where('create_user_id', auth()->user()->id)
                    ->get();
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
            $posts = Posts::where('create_user_id', auth()->user()->id)
                ->get();
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
        $file = $request->file('csvfile');
        try {
            $content = file_get_contents($file->getRealPath());
            $content = str_replace(["\r\n", "\r"], "\n", $content);
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.csv';
            file_put_contents($tempPath, $content);
            $csv = Reader::createFromPath($tempPath, 'r');
            $csv->setHeaderOffset(0);
            $header = $csv->getHeader();
            if (count($header) !== 3) {
                dd($header);
                return redirect()->back()->with('error', 'CSV must have exactly 3 columns.')->withInput();
            }
            $records = Statement::create()->process($csv);
            foreach ($records as $record) {
                if (count($record) !== 3) {
                    return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                }
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
            $request->session()->flash('create', 'CSV data uploaded successfully.');
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.postList');
            } else {
                return redirect()->route('user.postList');  }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
        }
    }
}

