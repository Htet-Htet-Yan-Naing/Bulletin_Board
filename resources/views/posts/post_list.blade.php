@extends('layouts.app')
@section('title', 'Post list')
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
            <form action="{{ route('searchPost', ['search' => request('search')]) }}" method="get" class="d-inline" style="position:relative;">
              @csrf
              <input class="search-btn p-2" type="text" name="search" value="{{ request('search') }}" placeholder="Type Something" style="border:1px solid black;border-radius:8px;">
              @error('search')
                <span class="text-red-600" style="position:absolute;top:30px;left:0;">{{$message}}</span>
              @enderror
              <button type="submit" class="btn btn-success btn-lg">Search</button>
            </form>
            <form action="{{ route('createPost') }}" method="get" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success btn-lg">Create</button>
            </form>
            <form action="{{ route('posts.upload')}}" method="get" class="d-inline">
              @csrf
              <input type="hidden" name="search" value="{{ request('search') }}">
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
        <a href="#" data-bs-toggle="modal" data-bs-target="#postDetailModal" data-id="{{ $rs->id }}" data-title="{{ $rs->title }}" data-description="{{ $rs->description }}" data-status="{{$rs->status}}" data-createdDate="{{$rs->created_at->format('Y-m-d') }}" data-updatedDate="{{ $rs->created_at->format('Y-m-d') }}" data-createdUser="{{ $rs->user->type }}" data-updatedUser="{{ $rs->user->type }}" id="post-detail-link">{{ $rs->title }}
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
          {!! $posts->links() !!}
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
        <p>Are you sure you want to delete the post?</p>
        <p><strong>ID:</strong> <span id="postId"></span></p>
        <p><strong>Title:</strong> <span id="postTitle"></span></p>
        <p><strong>Description:</strong> <span id="postDescription"></span></p>
        <p><strong>Status:</strong> <span id="postStatus"></span></p>
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
        <p><strong>ID:</strong> <span id="postId" style="color:red;"></span></p>
        <p><strong>Title:</strong> <span id="postTitle" style="color:red;"></span></p>
        <p><strong>Description:</strong> <span id="postDescription" style="color:red;"></span></p>
        <p><strong>Status:</strong> <span id="postStatus" style="color:red;"></span></p>
        <p><strong>Created Date:</strong> <span id="postCreateDate" style="color:red;"></span>
        <p><strong>Updated Date:</strong> <span id="postUpdateDate" style="color:red;"></span>
        <p><strong>Created User:</strong> <span id="postCreateUser" style="color:red;"></span>
        <p><strong>Updated User:</strong> <span id="postUpdateUser" style="color:red;"></span>
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
      // Update modal content
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
</script>
@endsection