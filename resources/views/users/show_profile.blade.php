@extends('layouts.app')
@section('title', 'Profile')
@section('contents') 
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-8">
    <div class="card-custom">
      <div class="card-header-custom p-3 txtColor">
        Profile
      </div>
      <div class="card-body">
        <form method="GET">
          @csrf
          <div class="row">
            <!-- Profile Image Column -->
            <div class="col-md-4">
              <div class="row mt-3">
                <div class="col-md-12 text-center ">
                  <img src="{{ asset($imagePath) }}" alt="Profile Image" class="rounded" width="200" height="200" name="profile">
                </div>
              </div>
            </div>
            <!-- Profile Details Column -->
            <div class="col-md-8">
              <div class="row align-items-center py-3">
                <div class="col-md-3">
                  <label class="mb-0">Name:</label>
                </div>
                <div class="col-md-9">
                  <label class="control-label col-sm-12" name="name">{{ $user->name }}</label>
                </div>
              </div>
              <div class="row align-items-center py-3">
                <div class="col-md-3">
                  <label class="mb-0">Email:</label>
                </div>
                <div class="col-md-9">
                  <label class="control-label col-sm-12" name="email">{{ $user->email }}</label>
                </div>
              </div>
              <div class="row align-items-center py-3">
                <div class="col-md-3">
                  <label class="mb-0">Phone:</label>
                </div>
                <div class="col-md-9">
                  <label class="control-label col-sm-12" name="phone">{{ $user->phone }}</label>
                </div>
              </div>
              <div class="row align-items-center py-3">
                <div class="col-md-3">
                  <label class="mb-0">DOB:</label>
                </div>
                <div class="col-md-9">
                  <label class="control-label col-sm-12" name="dob">{{ $user->dob }}</label>
                </div>
              </div>
              <div class="row align-items-center py-3">
                <div class="col-md-3">
                  <label class="mb-0">Address:</label>
                </div>
                <div class="col-md-9">
                  <label class="control-label col-sm-12" name="address">{{ $user->address }}</label>
                </div>
              </div>
              <!-- Edit Profile Button -->
              <div class="row align-items-center py-3">
                <div class="col-md-12 text-start">
                  <a href="{{ route('editProfile', $user->id)}}" type="button" class="btn btnColor">Edit Profile</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
