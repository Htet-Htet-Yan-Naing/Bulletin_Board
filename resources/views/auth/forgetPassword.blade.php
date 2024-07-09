@extends('layouts.app')
@section('title', 'Forgot Password?')
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-7">
    <div class="card-custom">
      <div class="card-header-custom p-3 txtColo">
        Forgot Password?
      </div>
      @if(Session::has('success'))
      <div class="alert alert-success" role="alert" style="width:100%;" id="success-alert">
        {{ Session::get('success') }}
      </div>
    @endif
      <div class="card-body">
        <form action="{{ route('forget.password.post') }}" method="post">
          @csrf
          <div class="mb-3 mt-3 row d-flex">
            <label for="current-pw" class="control-label col-sm-4">Email:</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email" name="email" required>
              @error('email')
          <span class="text-red-600">{{$message}}</span>
        @enderror
            </div>
          </div>
          <div class="row d-flex justify-content-center align-content-center">
            <div class="col-sm-4">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btnColor btn-block col-sm-12">Reset Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
      setTimeout(function () {
        successAlert.remove();
        location.reload();
      }, 4000);
    }
  });
  </script>
@endsection

