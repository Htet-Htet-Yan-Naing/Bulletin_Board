@extends('layouts.app')
@section('title', 'Post list')
@section('contents')
@if(Session::has('create'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('create') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
<div class="mb-4">
  <!-- Page size -->
  <form action="{{ route('searchPost', ['search' => request('search')]) }}" method="get" class="d-inline" style="position:relative;">
    @csrf
    <label class="txtColor">Page size:</label>
    <input type="hidden" class="search-btn p-2" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
    <select name="pageSize" class="pagination-selector" onchange="this.form.submit()">
      <option value="4" {{ request()->input('pageSize') == 4 ? 'selected' : '' }}>4</option>
      <option value="5" {{ request()->input('pageSize') == 5 ? 'selected' : '' }}>5</option>
      <option value="10" {{ request()->input('pageSize') == 10 ? 'selected' : '' }}>10</option>
      <option value="20" {{ request()->input('pageSize') == 20 ? 'selected' : '' }}>20</option>
    </select>
  </form>
  <!-- Page size -->

  <!-- Search by title and description start-->
  <form action="{{ route('searchPost', ['search' => request('search')]) }}" method="get" class="d-inline" style="position:relative;">
    @csrf
    <label class="search txtColor"> Keyword: </label>
    <input type="text" class="search-btn p-2" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
    @error('search')
    <span class="searchError text-red-600 alert alert-danger mt-2" style="position:absolute;top:30px;right:65px;z-index:100;" id="searchError">{{$message}}</span>
  @enderror
    <button type="submit" class="btn btnColor">Search</button>
  </form>
  <!-- Search by title and description end-->

  <!-- Create -->
  <form action="{{ route('createPost') }}" method="get" class="d-inline">
    @csrf
    <button type="submit" class="btn btnColor">Create</button>
  </form>
  <!-- Create -->

  <!-- Upload -->
  <form action="{{ route('posts.upload')}}" method="get" class="d-inline">
    @csrf
    <!--<input type="hidden" name="search" value="{{ request('search') }}">-->
    <button type="submit" class="btn btnColor">Upload</button>
  </form>
  <!-- Upload -->

  <!-- Download -->
  <form action="{{ route('posts.download')}}" method="get" class="d-inline">
    @csrf
    <input type="hidden" name="search" value="{{ request('search') }}">
    <button type="submit" class="btn btnColor">Download</button>
  </form>
  <!-- Download -->
</div>
</div>


























<!-- Posts row start -->
<div>
  <div class="row mb-2">
    @if($posts->count() > 0)
      @foreach($posts as $rs)
      <div class="col-md-3">
      <div class="card p-3 mb-4 grow-on-hover">
      <div class="d-flex justify-content-between">
        <div class="d-flex flex-row">

        <div class="icon">
        <img src="../{{ $rs->user->profile}}" class="profile-img">

        </div>
        <div class="ms-2 c-details">
        <h6 class="mb-0 user-name">{{ $rs->user->name}}</h6> <span>{{ $rs->created_at->format('Y-m-d') }}</span>
        </div>
        </div>
        <div class="badge"> <span>{{ $rs->user->type}}</span> </div>
      </div>
      <div class="mt-3" style="font-weight:bold;">
        {{ $rs->title }}
      </div>
      <div class="mt-3">
        {{ $rs->description }}
      </div>
      <div class="">
        <span>
        <a href="#" class="view" data-bs-toggle="modal" data-bs-target="#postDetailModal" data-id="{{ $rs->id }}" data-title="{{ $rs->title }}" data-description="{{ $rs->description }}" data-status="{{$rs->status}}" data-createdDate="{{$rs->created_at->format('Y-m-d') }}" data-updatedDate="{{ $rs->created_at->format('Y-m-d') }}" data-createdUser="{{ $rs->user->name }}" data-updatedUser="{{ $rs->user->name }}" id="post-detail-link">
        View
        </a>
        </span>

        @auth
        <div class="mt-2">
        <form action="{{ route('edit', $rs->id)}}"  method="post" class="d-inline">
        @csrf
        <button class="edit" type="submit">
        <img src="../img/edit.png" class="img-edit">
        </button>
        </form>
        </div>

        <div class="mt-2">
        <form action="#" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button" class="trash" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $rs->id }}" data-title="{{ $rs->title }}" data-description="{{ $rs->description }}" data-status="{{$rs->status}}">
        <img src="../img/trash.png" class="img-trash">
        </button>
        </form>
        </div>
        @endauth













      </div>
      </div>
      </div>
    @endforeach
      </div>
      <!-- Posts row end -->

    @else
      <div class="row mb-2">
      Posts not found
      </div>
    @endif

</div>
<div class="pagination-container textColor">
  {{ $posts->appends(request()->query())->links() }}
</div>

<!-- Delete Confirmation Modal start-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title f-bold" id="deleteModalLabel">Delete Confirm</h5>
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
        <h3 class="modal-title f-bold" id="detailModalLabel">Post Detail</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="row mb-2"><strong class="col-md-4">ID:</strong> <span id="postId" class="col-md-8 f-bold"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Title:</strong> <span id="postTitle" class="col-md-8 f-bold"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Description:</strong> <span id="postDescription" class="col-md-8 f-bold"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Status:</strong> <span id="postStatus" class="col-md-8 f-bold"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Created Date:</strong> <span id="postCreateDate" class="col-md-8 f-bold"></span>
        <p class="row mb-2"><strong class="col-md-4">Updated Date:</strong> <span id="postUpdateDate" class="col-md-8 f-bold"></span>
        <p class="row mb-2"><strong class="col-md-4">Created User:</strong> <span id="postCreateUser" class="col-md-8 f-bold"></span>
        <p class="row mb-2"><strong class="col-md-4">Updated User:</strong> <span id="postUpdateUser" class="col-md-8 f-bold"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btnColor" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- Post Detail Modal end-->


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Function to remove search error after a timeout

    var searchError = document.getElementById("searchError");
    if (searchError) {
      setTimeout(function () {
        searchError.remove();

      }, 5000);
    }

    // Modal for showing post details
    const postDetailModal = document.getElementById('postDetailModal');
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

    // Remove success alert after a timeout
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
      setTimeout(function () {
        successAlert.remove();
        location.reload();
      }, 1000);
    }

    //if (!sessionStorage.getItem('messageDisplayed')) {
    //  var successAlert = document.getElementById('success-alert');
    //  if (successAlert) {
    //    setTimeout(function () {
    //      successAlert.remove();
    //      sessionStorage.setItem('messageDisplayed', 'true'); // Set flag in sessionStorage
    //      location.reload(); // Reload the page after removing the alert
    //    }, 1000); // Adjust the time (in milliseconds) as needed
    //  }
    //}
    // Pagination change event
    //document.getElementById('pagination').addEventListener('change', function () {
    //    var pageSize = this.value;
    //});

    // Modal for confirming post deletion
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
      modalTitle.textContent = "Delete Confirm";
      modalBodyDescription.textContent = postDescription;
      modalBodyStatus.textContent = postStatus == 1 ? 'Active' : 'Inactive';
      deleteForm.action = `/postlists/${postId}/destroy`;
    });
  });

  //document.addEventListener('DOMContentLoaded', function() {
  //    var successAlert = document.getElementById('success-alert');
  //    if (successAlert) {
  //      setTimeout(function () {
  //        successAlert.remove();
  //        location.reload(); // Reload the page after removing the alert
  //      }, 5000); // Adjust the time (in milliseconds) as needed
  //    }
  //  });
</script>
@endsection