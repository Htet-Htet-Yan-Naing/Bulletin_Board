@extends('layouts.app')
@section('title', 'Reset Password')
 @section('contents')
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-7">
          <div class="card">
            <div class="card-header bg-success p-3 text-white">
              Reset Password
            </div>
            <div class="card-body">
              <form>
                <!-- Current password -->
                <div class="mb-3 mt-3 row d-flex">
                  <label for="current-pw" class="control-label col-sm-4">Password:</label>
                  <div class="col-sm-8"> <input type="password" class="form-control" id="pw" name="pw"></div>
                </div>
                <!-- New password -->
                <div class="mb-3 row d-flex">
                  <label for="new-pw" class="control-label col-sm-4">Password Confirmation:</label>
                  <div class="col-sm-8"><input type="password" class="form-control" id="pw-confirm" name="pw-confirm"></div>
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