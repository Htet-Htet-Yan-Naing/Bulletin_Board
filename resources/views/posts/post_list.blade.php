@extends('layouts.app')
@section('title', 'Post list')
<!-- Changes happen here -->
@if(Session::has('success'))
  <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
  </div>
@endif
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-12">
    <div class="card" style="border-radius: 15px;">
      <div class="card-header bg-success p-3 text-white">
        Post List
      </div>
      <div class="card-body">
        <div class="float-end">
          <div class="container py-5">
            <label class=""> Keyword: </label>
            <form action="{{ route('searchPost') }}" method="get" class="d-inline">
              @csrf
              <input class="search-btn p-2" type="text" name="search" placeholder="Type Something" value="{{ request('search') }}" style="border:1px solid black;border-radius:8px;">
              <button type="submit" class="btn btn-success btn-lg">Search</button>
            </form>

            <form action="{{ route('createPost') }}" method="get" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success btn-lg">Create</button>
            </form>
            <button type="button" class="btn btn-success btn-lg">Upload</button>
            <button type="button" class="btn btn-success btn-lg">Download</button>
          </div>
        </div>
        <div class="container py-5">
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
        <td class="align-middle">{{ $rs->user->type}}</td>
        <td class="align-middle">{{ $rs->created_at->format('Y-m-d') }}</td>
        <td class="align-middle">
        <a href="{{ route('edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
        <!--<form action="#" method="POST" type="button" class="btn btn-danger p-0" >-->
        <!--@csrf-->
        <!-- onsubmit="return confirm('Delete?')"-->
        <button class="btn btn-danger m-0 delete-post-btn" onclick="document.getElementById('id01').style.display='block'">Delete</button>
        <!--</form>-->

        <!-- Delete Dialog Box -->
        <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
        <form class="modal-content" action="/action_page.php">
          <div class="container">
          <h1>Delete Account</h1>
          <p>Are you sure you want to delete your account?</p>

          <div class="clearfix">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
          </div>
          </div>
        </form>
        </div>
        <!-- Delete Dialog Box -->

        </td>
        </tr>
      @endforeach
        @else
        <tr>
        <td class="text-center" colspan="5">Posts not found</td>
        </tr>
      @endif
            </tbody>
          </table>
          {!! $posts->links() !!}
        </div>
      </div>
    </div>
  </div>
</div>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
@endsection
<!-- Changes happen here -->