@extends('layouts.app')
@section('title', 'User List')
@section('contents') 
@if(Session::has('success'))
  <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
  </div>
@endif
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-12">
    <div class="card" style="border-radius: 15px;">
      <div class="card-header bg-success p-3 text-white">
        User List
      </div>
      <div class="card-body">
      <div class="container">
  <div class="col-md-10 m-atuo">
  <div class="row mb-4">
  <form action="{{ route('searchUser') }}" method="get" class="form-horizontal row">
          @csrf
    <div class="col ms-2">
        <label class=""> Name: </label>
        <input class="search-btn p-2" type="text" name="name" value="{{ request('name') }}" style="border:1px solid black;border-radius:8px;">
        @error('name')
          <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
        @enderror
      </div>
    <div class="col ms-4">
        <label class=""> Email: </label>
        <input class="search-btn p-2" type="email" name="email" value="{{ request('email') }}" style="border:1px solid black;border-radius:8px;">
        @error('email')
          <div class="alert alert-danger mt-1  mb-0">{{ $message }}</div>
        @enderror
      </div>
    <div class="col ms-4">
        <label class=""> From: </label>
        <input class="search-btn p-2" type="date" name="start_date" value="{{ request('start_date') }}" style="border:1px solid black;border-radius:8px;">
        @error('start_date')
          <div class="alert alert-danger mt-1  mb-0">{{ $message }}</div>
        @enderror
      </div>
    <div class="col">
        <label class=""> To: </label>
        <input class="search-btn p-2" type="date" name="end_date" value="{{ request('end_date') }}" style="border:1px solid black;border-radius:8px;">
        @error('end_date')
          <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
        @enderror
      </div>
    <div class="col mt-3">
          <button type="submit" class="btn btn-success btn-lg">Search</button>
    </form>
    </div>
  </div>
</div>
      </div>
      <table class="table table-hover table-striped">
        <thead class="table-primary">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created User</th>
            <th>Type</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Operation</th>
          </tr>
        </thead>
        <tbody>
          @if($users->count() > 0)
          @foreach($users as $rs)
        <tr>
        <td class="align-middle">
        <a href="#" data-bs-toggle="modal" data-bs-target="#userDetailModal" 
            data-id="{{ $rs->id }}" data-name="{{ $rs->name }}"
            data-type="{{ $rs->type }}" data-email="{{ $rs->email }}"
            data-phone="{{ $rs->phone }}" 
            data-dob="{{ $rs->dob }}" data-address="{{ $rs->address }}"
            data-created-at="{{ $rs->created_at }}" data-created-user="{{$rs->creator->name}}"
            data-updated-at="{{ $rs->updated_at }}" data-updated-user="{{$rs->updateBy->name}}"
             id="user-detail-link">{{ $rs->name }}
        </a>
        </td>
        <td class="align-middle">{{ $rs->email }}</td>
        <td class="align-middle">{{ $rs->creator->name }}</td>
        <td class="align-middle">{{ $rs->type}}</td>
        <td class="align-middle">{{ $rs->phone }}</td>
        <td class="align-middle">{{ $rs->dob }}</td>
        <td class="align-middle">{{ $rs->address }}</td>
        <td class="align-middle">
        <a href="{{ route('profile', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $rs->id }}" data-name="{{ $rs->name }}" data-type="{{ $rs->type }}" data-email=" {{ $rs->email }}" data-phone="{{ $rs->phone }}" data-dob="{{ $rs->dob }}" data-address=" {{ $rs->address }}">
        Delete
        </button>
        </td>
        </tr>
      @endforeach
      @else
      <tr>
      <td class="text-center" colspan="8">Product not found</td>
      </tr>
    @endif
        </tbody>
      </table>
      {!! $users->links() !!}
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
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="color:red;">Are you sure to delete user?</p>
        <p class="row mb-2"><strong class="col-md-3">ID: </strong> <span id="userId" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Name:</strong> <span id="userName" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Type:</strong> <span id="userType" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Email:</strong> <span id="userEmail" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Phone:</strong> <span id="userPhone" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Dob:</strong> <span id="userDob" class="col-md-9"></span></p>
        <p class="row mb-2"><strong class="col-md-3">Address:</strong> <span id="userAddress" class="col-md-9"></span></p>
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
<!-- End Delete Confirmation Modal -->
<!-- User Detail Modal start-->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Post Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="row mb-2"><strong class="col-md-4">Name:</strong> <span id="userName" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Type:</strong> <span id="userType" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Email:</strong> <span id="userEmail" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Phone:</strong> <span id="userPhone" class="col-md-8"></span>
        <p class="row mb-2"><strong class="col-md-4">Date of Birth:</strong> <span id="userDob" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Address:</strong> <span id="userAddress" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Created at:</strong> <span id="userCreatedAt" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Created user:</strong> <span id="userCreated" class="col-md-8"></span>
        <p class="row mb-2"><strong class="col-md-4">Updated at:</strong> <span id="userUpdatedAt" class="col-md-8"></span></p>
        <p class="row mb-2"><strong class="col-md-4">Updated user:</strong> <span id="userUpdated" class="col-md-8"></span>
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
    const userId = button.getAttribute('data-id');
    const userName = button.getAttribute('data-name');
    const userType = button.getAttribute('data-type');
    const userEmail = button.getAttribute('data-email');
    const userPhone = button.getAttribute('data-phone');
    const userDob = button.getAttribute('data-dob');
    const userAddress = button.getAttribute('data-address');
    const modalBodyId = deleteModal.querySelector('#userId');
    const modalBodyName = deleteModal.querySelector('#userName');
    const modalBodyType = deleteModal.querySelector('#userType');
    const modalBodyEmail = deleteModal.querySelector('#userEmail');
    const modalBodyPhone = deleteModal.querySelector('#userPhone');
    const modalBodyDob = deleteModal.querySelector('#userDob');
    const modalBodyAddress = deleteModal.querySelector('#userAddress');
    modalBodyId.textContent = userId;
    modalBodyName.textContent = userName;
    modalBodyType.textContent = userType;
    modalBodyEmail.textContent = userEmail;
    modalBodyPhone.textContent = userPhone;
    modalBodyDob.textContent = userDob;
    modalBodyAddress.textContent = userAddress;
    const deleteForm = deleteModal.querySelector('#deleteForm');
    deleteForm.action = `/userlists/${userId}/destroy`;
  });

  document.addEventListener('DOMContentLoaded', function () {
    const userDetailModal = document.getElementById('userDetailModal');
    const userDetailLink = document.getElementById('user-detail-link');
    userDetailModal.addEventListener('show.bs.modal', function (event) {
      const link = event.relatedTarget;
      const userName = link.getAttribute('data-name');
      const userType = link.getAttribute('data-type');
      const userEmail = link.getAttribute('data-email');
      const userPhone = link.getAttribute('data-phone');
      const userDob = link.getAttribute('data-dob');
      const userAddress = link.getAttribute('data-address');
      const userCreatedAt = link.getAttribute('data-created-at');
      const userUpdatedAt = link.getAttribute('data-updated-at');
      const userCreated = link.getAttribute('data-created-user');
      const userUpdated = link.getAttribute('data-updated-user');
      const modalTitle = userDetailModal.querySelector('.modal-title');
      const modalBodyName = userDetailModal.querySelector('#userName');
      const modalBodyType = userDetailModal.querySelector('#userType');
      const modalBodyEmail = userDetailModal.querySelector('#userEmail');
      const modalBodyPhone = userDetailModal.querySelector('#userPhone');
      const modalBodyDob = userDetailModal.querySelector('#userDob');
      const modalBodyAddress = userDetailModal.querySelector('#userAddress');
      const modalBodyCreatedAt = userDetailModal.querySelector('#userCreatedAt');
      const modalBodyUpdatedAt = userDetailModal.querySelector('#userUpdatedAt');
      const modalBodyCreatedUser = userDetailModal.querySelector('#userCreated');
      const modalBodyUpdatedUser = userDetailModal.querySelector('#userUpdated');
      modalTitle.textContent = "User Detail";
      modalBodyName.textContent = userName;
      modalBodyEmail.textContent = userEmail;
      modalBodyPhone.textContent = userPhone;
      modalBodyType.textContent = userType == 0 ? 'Admin' : 'User';
      modalBodyDob.textContent = userDob;
      modalBodyAddress.textContent = userAddress;
      modalBodyCreatedAt.textContent = userCreatedAt;
      modalBodyUpdatedAt.textContent = userUpdatedAt;
      modalBodyCreatedUser.textContent = userCreated;
      modalBodyUpdatedUser.textContent = userUpdated;
    });
  }); 
</script>

@endsection