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
            <form action="{{ route('searchPost', ['search' => request('search')]) }}" method="get" class="d-inline">
            <!--value="{{ request('search') }}"-->
              @csrf
              <input class="search-btn p-2" type="text" name="search" value="{{ old('text') }}" placeholder="Type Something"  style="border:1px solid black;border-radius:8px;">
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
            


            <!--<button type="button" class="btn btn-success btn-lg">Download</button>-->
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

            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $rs->id }}"
                                                        data-title="{{ $rs->title }}" data-description="{{ $rs->description }}"
                                                        data-status="{{$rs->status}}" >Delete</button>

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

 <!-- Delete Confirmation Modal -->
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

    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
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
    </script>



@endsection
<!-- Changes happen here -->