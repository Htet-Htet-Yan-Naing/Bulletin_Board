@extends('layouts.app')
@section('title', 'Register')
@section('contents') 
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">
          <div class="card-custom" style="border-radius: 15px;">
            <div class="card-header-custom p-3 txtColor">
              Register
            </div>
            <div class="card-body">
              <form action="{{ route('confirmRegister')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center pt-4 pb-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Full name</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control" name="name" id="name"/>
                    @error('name')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Email address</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}"/>
                    @error('email')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Password</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="password" class="form-control" name="pw" id="pw"/>
                    @error('pw')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Confirm Password</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="password" class="form-control" name="pw_confirmation" id="pw_confirmation"/>
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Type</label>
                  </div>
                  <div class="col-md-9 pe-5">
    @auth
        <!-- Check if the authenticated user is an admin -->
        @if(auth()->user()->type=='admin')
            <select name="type" id="type" class="form-select">
                <option value="" selected>Select Type</option>
                <option value="0">Admin</option>
                <option value="1">User</option>
            </select>
        @elseif(auth()->user()->type=='user')
            <select name="type" id="type" class="form-select">
                <option value="" selected>Select Type</option>
                <option value="1">User</option>
            </select>
        @else
            <!-- Handle other roles or show a default message -->
            <p>Unknown role</p>
        @endif
    @else
        <!-- Show this if the user is not authenticated -->
        <p>Please log in to see your role.</p>
    @endauth
</div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Phone</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="phone" class="form-control" name="phone" id="phone"/>
                    @error('phone')
                            <span class="text-red-600">{{$message}}</span>
                    @enderror
                    
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">DOB</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control" id="dob" type="date" name="dob" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Address</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control" name="address" id="address"/>
                    @error('address')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Profile</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="file" class="form-control" id="profile" name="profile" />
                    @error('profile')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <!-- Button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btnColor btn-block col-sm-4">Register</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endsection