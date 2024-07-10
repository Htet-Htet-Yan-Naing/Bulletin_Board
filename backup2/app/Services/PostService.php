<?php
namespace App\Services;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use Exception;
class PostService
{
  public function posts(Request $request)
  {
      $pageSize = $request->input('pageSize', 4); 
      $posts = Posts::where('status', 1)->latest()->paginate($pageSize);
      return $posts;
  }
  public function postlist(Request $request)
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

  public function searchPost($request)
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
  }
  public function edit(string $id)
  {
      $posts = Posts::findOrFail($id);
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
      $post = Posts::findOrFail($id);
      $toggleStatus =  $request->session()->get('toggleStatus');
      $request->session()->put('toggleStatus', $toggleStatus);
     $toggleStatus = $request->toggleStatus;
      if ($toggleStatus == 1) {
          $post->status = 1;
      } else {
          $post->status = 0;
      }
      $post->update($request->all());
      $request->session()->flash('create', 'Post updated successfully!');
  }
  public function destroy(Request $request, $id)
  {
      $post = Posts::findOrFail($id);
      $deleted = Posts::destroy($id);
      $request->session()->flash('create', 'Post deleted successfully!');
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
        $file = $request->file('csvfile');
        if($file == ""){
            return redirect()->back()->with('error', 'Enter file')->withInput();
        }
        $tempPath = sys_get_temp_dir().'/'.uniqid().'csv';

      
            $file_type= $request->file('csvfile')->getClientOriginalExtension();
      
       
        if($file_type !== 'csv'){
            return ['error'=> 'File must be csv type.'];
        }
       
        try {
            // Move the uploaded file to a temporary location
            $file->move(sys_get_temp_dir(), $tempPath);

            // Read the content of the file
            $csv = Reader::createFromPath($tempPath, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();
           // dd( $records );
            foreach ($records as $record) {
                      // Validate the CSV data structure
                      if (count($record) !== 3) {
                        DB::rollBack();
                        return ['error'=> 'Each row in the CSV must have exactly 3 columns.'];
                    }
                    $existingPost = Posts::where('title', $record['title'])->first();
                    if ($existingPost) {
                        ///dd("Post exist");
                        return[ 'error'=>'Post title already exists:'.$record['title']];
                       
                    }
            }
            foreach ($records as $record) {
                        
                if (count($record) !== 3) {
                    //dd("Header is not equal to three");
                    return ['error'=>'Each row in the CSV must have exactly 3 columns.'];
                }
                
                    // Create or update posts based on CSV data
                    Posts::create([
                        'title' => $record['title'],
                        'description' => $record['description'],
                        'status' => $record['status'],
                        'create_user_id' => Auth::id(),
                        'updated_user_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
             
            $request->session()->flash('create', 'CSV data uploaded successfully.');
                if (auth()->user()->type == 'admin') {
                    return redirect()->route('admin.postList');
                } else {
                    return redirect()->route('user.postList');
                }
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
        } 
    }

}