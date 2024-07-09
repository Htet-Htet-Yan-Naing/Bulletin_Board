@extends('layouts.app')
@section('title', 'Change Password')
 @section('contents')
      <div class="row d-flex justify-content-center align-items-center h-100 mt">
        <div class="col-xl-7">
          <div class="card-custom">
            <div class="card-header-custom p-3 txtColor">
              Change Password
            </div>
            <div class="card-body">
              <form action="{{ route('update_password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Current password -->
                <div class="mb-3 mt-3 row d-flex">
                  <label for="current-pw" class="control-label col-sm-4">Current password:</label>
                  <div class="col-sm-8"> 
                    <input type="password" class="form-control" id="currentPw" name="currentPw">
                    @error('currentPw')
                            <span class="text-red-600">{{ $message }}</span>
                    @enderror
                 </div>
                </div>
                <!-- New password -->
                <div class="mb-3 row d-flex">
                  <label for="new-pw" class="control-label col-sm-4">New Password:</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control @error('newPw') is-invalid @enderror" id="newPw" name="newPw">
                    @error('newPw')
                            <span class="text-red-600">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <!-- New confirm password -->
                <div class="mb-3 row d-flex">
                  <label for="new-pw" class="control-label col-sm-4">New confirm Password:</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="pw_confirmation" name="pw_confirmation">
                    @error('pw_confirmation')
                            <span class="text-red-600">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <!-- Submit button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-4">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btnColor btn-block col-sm-12">Update password</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection    