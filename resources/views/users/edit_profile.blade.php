@extends('layouts.app')
@section('title', 'Edit Profile')
@section('contents') 
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-8">
    <div class="card" style="border-radius: 15px;">
      <div class="card-header bg-success p-3 text-white">
        Profile Edit
      </div>
      <div class="card-body">
        <form action="{{ route('updateProfile', $user->id) }}" method="POST">
          @csrf
          <div class="row align-items-center pt-4 pb-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Full name</label>
            </div>
            <div class="col-md-9 pe-5">
              <input type="text" class="form-control" value="{{ $user->name }}" name="name"/>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Email address</label>
            </div>
            <div class="col-md-9 pe-5">
              <input type="email" class="form-control" placeholder="example@example.com" value="{{ $user->email }}" name="email"/>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Type</label>
            </div>
            <div class="col-md-9 pe-5">
                    <select name="type" id="type" class="form-select">
                       <option value="0" {{ $user->type == 0 ? 'selected' : '' }}>Admin</option>
                       <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>User</option>
                    </select>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Phone</label>
            </div>
            <div class="col-md-9 pe-5">
              <input type="phone" class="form-control" value="{{ $user->phone }}" name="phone"/>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Date of Birth</label>
            </div>
            <div class="col-md-9 pe-5">
              <input class="form-control" id="dd" type="date" name="date" value="{{ $user->dob }}" name="dob"/>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Address</label>
            </div>
            <div class="col-md-9 pe-5">
              <input type="phone" class="form-control" value="{{ $user->address }}" name="address"/>
            </div>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-md-3 ps-5">
              <label class="mb-0">Old Profile</label>
            </div>
            <div class="col-md-9 pe-5">
              <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200" name="profile">
            </div>
          </div>

          <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">New Profile</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="file" class="form-control" id="profile" name="new-profile" />
                    @error('profile')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
          </div>
          <!-- Button -->
          <div class="row d-flex justify-content-center align-content-center">
            <div class="col-sm-6">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-3">Edit</button>
              <button type="clear" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-3">Clear</button>
              <a href="{{ route('change_password', $user->id)}}" data-mdb-button-init data-mdb-ripple-init class="btn-block col-sm-7">Change password</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection