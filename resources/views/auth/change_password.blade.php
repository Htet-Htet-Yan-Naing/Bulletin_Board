@extends('layouts.app')
@section('title', 'Login')
 @section('contents')
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-7">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Change password
            </div>
            <div class="card-body">
              <form action="{{ route('update_password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Current password -->
                <div class="mb-3 mt-3 row d-flex">
                  <label for="current-pw" class="control-label col-sm-4">Current password:</label>
                  <div class="col-sm-8"> <input type="password" class="form-control" id="current-pw" name="currentPw"></div>
                </div>
                <!-- New password -->
                <div class="mb-3 row d-flex">
                  <label for="new-pw" class="control-label col-sm-4">New Password:</label>
                  <div class="col-sm-8"><input type="password" class="form-control" id="new-pw" name="newPw"></div>
                </div>
                <!-- New confirm password -->
                <div class="mb-3 row d-flex">
                  <label for="new-pw" class="control-label col-sm-4">New confirm Password:</label>
                  <div class="col-sm-8"><input type="password" class="form-control" id="new-confirm-pw" name="newConfirmPw"></div>
                </div>
                <!-- Submit button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-4">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block col-sm-12">Update password</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection    