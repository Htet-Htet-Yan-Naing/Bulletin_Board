
@extends('layouts.app')
 
@section('body')
<hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
<div class="container">
<div class="col float-end mb-5">
<label class=""> Keyword: </label>
          <input class="search-btn p-2" type="text" name="search-keyword" placeholder="Type Something" style="border:1px solid black;border-radius:8px;">
  <button type="button" class="btn btn-success btn-lg">Search</button>    
  <button type="button" class="btn btn-success btn-lg">Create</button>    
  <button type="button" class="btn btn-success btn-lg">Upload</button>    
  <button type="button" class="btn btn-success btn-lg">Download</button> 
</div>   
</div>
    <table class="table table-hover table-striped">
        <thead class="table-primary">
            <tr>
                <th>Post Title</th>
                <th>Post Description</th>
                <th>Posted User</th>
                <th>Posted Date</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
        @if($posts->count() > 0)
                @foreach($posts as $rs)
                    <tr>
                        <td class="align-middle">{{ $rs->title }}</td>
                        <td class="align-middle">{{ $rs->description }}</td>
                        <td class="align-middle">admin</td>
                        <td class="align-middle">{{ $rs->created_at }}</td>
                        <td class="align-middle">
                           
                                <a href="{{ route('edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="#" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                           
                        </td>
                    </tr>
                    @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $posts->links() !!}
@endsection