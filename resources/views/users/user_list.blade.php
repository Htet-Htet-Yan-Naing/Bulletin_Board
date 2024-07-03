@extends('layouts.app')
@section('title', 'User List')
@section('contents') 
@if(Session::has('create'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('create') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-md-12">
 <!-- User Search Container start -->
 <!-- Search Row Start -->
<div class="user-search-container">
  <form action="{{ route('searchUser') }}" method="get" class="form-horizontal row mb-3">
    @csrf

    <!-- Page Size Select -->
    <div class="col-md-2">
      <label class="form-label txtColor">Page size:</label>
      <select name="pageSize" class="form-control pagination-selector" onchange="this.form.submit()">
        <option value="4" {{ request()->input('pageSize') == 4 ? 'selected' : '' }}>4</option>
        <option value="5" {{ request()->input('pageSize') == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request()->input('pageSize') == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request()->input('pageSize') == 20 ? 'selected' : '' }}>20</option>
      </select>
    </div>

    <!-- Name -->
    <div class="col-md-2">
      <label class="form-label txtColor">Name:</label>
      <input class="form-control" type="text" name="name" value="{{ request('name') }}" style="border-radius: 8px;">
      @error('name')
        <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
      @enderror
    </div>

    <!-- Email -->
    <div class="col-md-2">
      <label class="form-label txtColor">Email:</label>
      <input class="form-control" type="email" name="email" value="{{ request('email') }}" style="border-radius: 8px;">
      @error('email')
        <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
      @enderror
    </div>

    <!-- From Date -->
    <div class="col-md-2">
      <label class="form-label txtColor">From:</label>
      <input class="form-control" type="date" name="start_date" value="{{ request('start_date') }}" style="border-radius: 8px;">
      @error('start_date')
        <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
      @enderror
    </div>

    <!-- To Date -->
    <div class="col-md-2">
      <label class="form-label txtColor">To:</label>
      <input class="form-control" type="date" name="end_date" value="{{ request('end_date') }}" style="border-radius: 8px;">
      @error('end_date')
        <div class="alert alert-danger mt-1 mb-0">{{ $message }}</div>
      @enderror
    </div>

    <!-- Search Button -->
    <div class="col-md-2 user-search-div">
      <button type="submit" class="btn btnColor user-search-btn" style="width:100%;">Search</button>
    </div>

  </form>
</div>
<!-- Search Row End -->

 <!-- User Search Contaienr end -->



<!-- User Table start -->
<table class="table">
  <thead class="txtColor">
    <tr class="thead">
      <th class="profile-head">Profile</th>
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
    <tr class="row-des-color grow-on-hover">
      <td class="align-middle rounded-content" style="border-bottom:1px solid #EBEBEB;">
      <div class="icon">
      <img src="../{{ $rs->profile}}" class="profile-img" alt="Profile">
      </div>
      </td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">
      <a href="#" data-bs-toggle="modal" data-bs-target="#userDetailModal" data-id="{{ $rs->id }}" data-name="{{ $rs->name }}" data-type="{{ $rs->type }}" data-email="{{ $rs->email }}" data-phone="{{ $rs->phone }}" data-dob="{{ $rs->dob }}" data-address="{{ $rs->address }}" data-created-at="{{ $rs->created_at }}" data-created-user="{{$rs->creator->name}}" data-updated-at="{{ $rs->updated_at }}" data-updated-user="{{$rs->updateBy->name}}" id="user-detail-link">{{ $rs->name }}
      </a>
      </td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->email }}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->creator->name }}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->type}}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->phone }}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->dob }}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">{{ $rs->address }}</td>
      <td class="align-middle" style="border-bottom:1px solid #EBEBEB;">
      <button type="button" class="user-trash" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $rs->id }}" data-name="{{ $rs->name }}" data-type="{{ $rs->type }}" data-email=" {{ $rs->email }}" data-phone="{{ $rs->phone }}" data-dob="{{ $rs->dob }}" data-address=" {{ $rs->address }}">
      <img src="../img/trash.png" class="img-trash">
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
<!-- User Table end -->
<div class="pagination-container textColor" style="padding-bottom:0;">
  {{ $users->appends(request()->query())->links() }}
</div>
</div>
</div>
</div>


<!-- Delete Confirmation Modal start-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-danger pb-4">Are you sure to delete user?</p>
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
<!-- End Delete Confirmation Modal end -->

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
  document.addEventListener("DOMContentLoaded", function () {
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
      setTimeout(function () {
        successAlert.remove();
        location.reload();
      }, 1000);
    }
    //// Get the alert element
    //var alertElement = document.getElementById('success-alert');
    //
    //// If the alert element exists
    //if (alertElement) {
    //    // Set a timeout to remove the element after 5 seconds
    //    setTimeout(function() {
    //        alertElement.remove(); // Remove the alert element
    //    }, 5000); // 5000 milliseconds = 5 seconds
    //}
  });
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