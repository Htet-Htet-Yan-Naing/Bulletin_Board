@extends('layouts.app')
@section('title', 'Sign up')
 @section('contents')
 <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-7">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Sign Up
            </div>
            <div class="card-body">
              <form action="{{route('signup.save')}}" method="POST" novalidate>
              @csrf
              @method('POST')
                <!-- Name -->
                <div class="mb-3 mt-3 row d-flex">
                  <label for="name" class="control-label col-sm-4">Name:</label>
                  <div class="col-sm-8"> 
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                 
                </div>
                <!-- Email address -->
                <div class="mb-3 row d-flex">
                  <label for="email" class="control-label col-sm-4">Email Address:</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                            <span class="text-red-600">{{$message}}</span>
                   @enderror
                  </div>
                  
                </div>
                <!-- Password -->
                <div class="mb-3 row d-flex">
                  <label for="password" class="control-label col-sm-4">Password:</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control @error('pw') is-invalid @enderror" id="password" name="pw" value="{{ old('pw') }}">
                    @error('pw')
                            <span class="text-red-600">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                
                 <!-- Password Confirmation -->
                 <div class="mb-3 row d-flex">
                  <label for="pw_confirmation" class="control-label col-sm-4">Password_confirmation:</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="pw_confirmation" name="pw_confirmation" value="{{ old('pw_confirmation') }}">
                    @error('pw_confirmation')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div> 
                </div>
                 <!-- Button -->
                 <div class="row d-flex">
                 <div class="col-sm-4"></div>
                  <div class="col-sm-8">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-3">Register</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-3">Clear</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
@endsection