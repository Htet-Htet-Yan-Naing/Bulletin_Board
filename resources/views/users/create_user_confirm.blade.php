@extends('layouts.app')
@section('title', 'Register Confirm')
@section('contents')     
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">
          <div class="card-custom" style="border-radius: 15px;">
            <div class="card-header-custom p-3 txtColor">
              Register Confirm
            </div>
            <div class="card-body">
              <form action="{{ route('user.save')}}" method="POST">
                @csrf
                <div class="row align-items-center pt-4 pb-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Full name</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control form-control-lg" value="{{ $user->name }}" name="name" id="name"/>
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
                    <input type="email" class="form-control form-control-lg" placeholder="example@example.com" value="{{ $user->email }}" name="email" id="email"/>
                    @error('email')
                            <span class="text-red-600" style="color:red;">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Password</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="password" class="form-control form-control-lg" value="{{ $user->pw }}" name="pw" id="pw"/>
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
                    <input type="password" class="form-control form-control-lg" value="{{ $user->pw_confirmation }}" id="pw_confirmation" name="pw_confirmation"/>
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Type</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <!-- <select name="type" id="type" class="form-select" value="{{ $user->type }}">
                      <option>Admin</option>
                      <option>User</option>
                    </select> -->
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
                    <input type="phone" class="form-control form-control-lg" value="{{ $user->phone }}" name="phone" id="phone"/>
                    @error('phone')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Date of Birth</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control form-control-lg" id="dd" type="date" name="dob" value="{{ $user->dob }}" id="dob"/>
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">Address</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control form-control-lg" value="{{ $user->address }}" name="address" id="address"/>
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
                    <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200">
                    <input type="hidden" name="imagePath" id="imagePath" class="form-control mt-2" value="{{$imagePath}}">
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