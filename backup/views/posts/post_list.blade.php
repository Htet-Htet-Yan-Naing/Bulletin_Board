@extends('layouts.app')
@section('title', 'Post list')
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header bg-success p-3 text-white">
        Post List
      </div>
      @if(Session::has('success'))
      <div class="alert alert-success" role="alert" id="success-alert">
      {{ Session::get('success') }}
      </div>
    @endif
      <div class="card-body">
        <div class="float-end">
          <div class="container py-5">
            <label class="form-control-lg"> Keyword: </label>
            <form action="{{ route('searchPost', ['search' => request('search')]) }}" method="get" class="d-inline" style="position:relative;">
              @csrf
              <input class="search-btn p-2" type="text" name="search" value="{{ request('search') }}" placeholder="Type Something" style="border:1px solid black;border-radius:8px;">
              @error('search')
          <span class="text-red-600 alert alert-danger mt-2 mb-2" style="position:absolute;top:30px;left:0;">{{$message}}</span>
        @enderror
              <button type="submit" class="btn btn-success btn-lg">Search</button>
            </form>
            <form action="{{ route('createPost') }}" method="get" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success btn-lg">Create</button>
            </form>
            <form action="{{ route('posts.upload')}}" method="get" class="d-inline">
              @csrf
              <!--<input type="hidden" name="search" value="{{ request('search') }}">-->
              <button type="submit" class="btn btn-success btn-lg">Upload</button>
            </form>
            <form action="{{ route('posts.download')}}" method="get" class="d-inline">
              @csrf
              <input type="hidden" name="search" value="{{ request('search') }}">
              <button type="submit" class="btn btn-success btn-lg">Download</button>
            </form>
          </div>
        </div>
        <div class="container py-5">
          <label for="pagination">Page size</label>
          <select id="pagination" class="pagination-selector">
            <option>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
          </select>
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
        <td class="align-middle" style="width:250px;">
        <a href="#" data-bs-toggle="modal" data-bs-target="#postDetailModal" data-id="{{ $rs->id }}" data-title="{{ $rs->title }}" data-description="{{ $rs->description }}" data-status="{{$rs->status}}" data-createdDate="{{$rs->created_at->format('Y-m-d') }}" data-updatedDate="{{ $rs->created_at->format('Y-m-d') }}" data-createdUser="{{ $rs->user->name }}" data-updatedUser="{{ $rs->user->name }}" id="post-detail-link">{{ $rs->title }}
        </a>
        </td>
        <td class="align-middle" style="width:400px;">{{ $rs->description }}</td>
        <td class="align-middle">{{ $rs->user->type}}</td>
        <td class="align-middle">{{ $rs->created_at->format('Y-m-d') }}</td>
        <td class="align-middle">
        <a href="{{ route('edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $rs->id }}" data-title="{{ $rs->title }}" data-description="{{ $rs->description }}" data-status="{{$rs->status}}">Delete</button>
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
          <div id="pagination-container">
            {!! $posts->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Delete Confirmation Modal start-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="color:red;" class="mb-2">Are you sure you want to delete post?</p>
        <p class="row mb-2"><strong class="col-md-3">ID:</strong> <span id="postId" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Title:</strong> <span id="postTitle" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Description:</strong> <span id="postDescription" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Status:</strong> <span id="postStatus" class="col-md-9"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form id="deleteForm" action="#" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Delete Confirmation Modal end-->
<!-- Post Detail Modal start-->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Post Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="row mb-2"><strong class="col-md-4">ID:</strong> <span id="postId" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Title:</strong> <span id="postTitle" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Description:</strong> <span id="postDescription" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Status:</strong> <span id="postStatus" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Created Date:</strong> <span id="postCreateDate" class="col-md-8"></span>
        <p class="row mb-2"><strong class="col-md-4">Updated Date:</strong> <span id="postUpdateDate" class="col-md-8"></span>
        <p class="row mb-2"><strong class="col-md-4">Created User:</strong> <span id="postCreateUser" class="col-md-8"></span>
        <p class="row mb-2"><strong class="col-md-4">Updated User:</strong> <span id="postUpdateUser" class="col-md-8"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Post Detail Modal end-->
<script>
  const deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const postId = button.getAttribute('data-id');
    const postTitle = button.getAttribute('data-title');
    const postDescription = button.getAttribute('data-description');

    const postStatus = button.getAttribute('data-status');
    const modalTitle = deleteModal.querySelector('.modal-title');
    const modalBodyId = deleteModal.querySelector('#postId');
    const modalBodyTitle = deleteModal.querySelector('#postTitle');
    const modalBodyDescription = deleteModal.querySelector('#postDescription');
    const modalBodyStatus = deleteModal.querySelector('#postStatus');
    modalTitle.textContent = `Delete Confirm - ${postTitle}`;
    modalBodyId.textContent = postId;
    modalBodyTitle.textContent = postTitle;
    modalBodyDescription.textContent = postDescription;
    modalBodyStatus.textContent = postStatus == 1 ? 'Active' : 'Inactive';
    deleteForm.action = `/postlists/${postId}/destroy`;
  });
  document.addEventListener('DOMContentLoaded', function () {
    const postDetailModal = document.getElementById('postDetailModal');
    const postDetailLink = document.getElementById('post-detail-link');
    postDetailModal.addEventListener('show.bs.modal', function (event) {
      const link = event.relatedTarget;
      const postId = link.getAttribute('data-id');
      const postTitle = link.getAttribute('data-title');
      const postDescription = link.getAttribute('data-description');
      const postStatus = link.getAttribute('data-status');
      const postCreateDate = link.getAttribute('data-createdDate');
      const postUpdateDate = link.getAttribute('data-updatedDate');
      const postCreateUser = link.getAttribute('data-createdUser');
      const postUpdateUser = link.getAttribute('data-updatedUser');
      const modalTitle = postDetailModal.querySelector('.modal-title');
      const modalBodyId = postDetailModal.querySelector('#postId');
      const modalBodyTitle = postDetailModal.querySelector('#postTitle');
      const modalBodyDescription = postDetailModal.querySelector('#postDescription');
      const modalBodyStatus = postDetailModal.querySelector('#postStatus');
      const modalBodyCreateDate = postDetailModal.querySelector('#postCreateDate');
      const modalBodyUpdateDate = postDetailModal.querySelector('#postUpdateDate');
      const modalBodyCreateUser = postDetailModal.querySelector('#postCreateUser');
      const modalBodyUpdateUser = postDetailModal.querySelector('#postUpdateUser');
      modalTitle.textContent = "Post Detail";
      modalBodyId.textContent = postId;
      modalBodyTitle.textContent = postTitle;
      modalBodyDescription.textContent = postDescription;
      modalBodyCreateDate.textContent = postCreateDate;
      modalBodyUpdateDate.textContent = postUpdateDate;
      modalBodyCreateUser.textContent = postCreateUser;
      modalBodyUpdateUser.textContent = postUpdateUser;
      modalBodyStatus.textContent = postStatus == 1 ? 'Active' : 'Inactive';

    });
  });
  document.getElementById('pagination').addEventListener('change', function () {
    var pageSize = this.value;
    var route = "{{ route('postlist') }}"; // Replace with correct route name
    window.location.href = route + '?page_size=' + pageSize;
  });

  document.addEventListener("DOMContentLoaded", function() {
        // Get the alert element
        var alertElement = document.getElementById('success-alert');
        
        // If the alert element exists
        if (alertElement) {
            // Set a timeout to remove the element after 5 seconds
            setTimeout(function() {
                alertElement.remove(); // Remove the alert element
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    });
</script>
@endsection