@extends('layouts.app')
@section('title', 'Login')
@section('contents') 
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-8">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Profile
            </div>
            <div class="card-body">
              <form method="GET">
                @csrf
                <!-- float:left -->
                <div class="row align-items-center py-3 float-start col-md-4">
                  <div class="col-md-3 ps-12">
                  </div>
                  <div class="col-md-9 pe-5">
                    <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200" name="profile">
                  </div>
                </div>
                <!-- float:right -->
                <div class="float-end col-md-8 ps-5">
                  <div class="row align-items-center py-3 ">
                    <div class="col-md-3 ">
                      <label class="mb-0">Name</label>
                    </div>
                    <div class="col-md-9">
                      <label class="control-label col-sm-12" name="name">{{ $user->name }}</label>
                    </div>
                  </div>
                  <div class="row align-items-center py-3">
                    <div class="col-md-3">
                      <label class="mb-0">Email</label>
                    </div>
                    <div class="col-md-9">
                      <label class="control-label col-sm-12" name="email">{{ $user->email }}</label>
                    </div>
                  </div>
                  <div class="row align-items-center py-3">
                    <div class="col-md-3">
                      <label class="mb-0">Phone</label>
                    </div>
                    <div class="col-md-9">
                      <label class="control-label col-sm-12" name="phone">{{ $user->phone }}</label>
                    </div>
                  </div>
                  <div class="row align-items-center py-3">
                    <div class="col-md-3">
                      <label class="mb-0">DOB</label>
                    </div>
                    <div class="col-md-9">
                      <label class="control-label col-sm-12" name="dob">{{ $user->dob }}</label>
                    </div>
                  </div>
                  <div class="row align-items-center py-3">
                    <div class="col-md-3">
                      <label class="mb-0">Address</label>
                    </div>
                    <div class="col-md-9 ">
                      <label class="control-label col-sm-12" name="address">{{ $user->address }}</label>
                    </div>
                  </div>
                  <!-- Button -->
                  <a href="{{ route('editProfile', $user->id)}}" type="button" class="btn btn-success">Edit profile</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endsection