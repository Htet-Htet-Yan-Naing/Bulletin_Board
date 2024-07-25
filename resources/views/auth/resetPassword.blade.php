@extends('layouts.app')
@section('title', 'Reset Password')
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100 mt">
  <div class="col-xl-7">
    <div class="card-custom">
      <div class="card-header-custom p-3 txtColor">
        Reset Password
      </div>
      @if(Session::has('success'))
  <script>
    iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    position: 'topRight', 
    });
    document.addEventListener('DOMContentLoaded', function () {
    iziToast.success({
      title: '',
      position: 'topRight',
      class: 'iziToast-custom',
      message: `{{ Session::get('success') }}`
    });
    });
  </script>
   @elseif(Session::has('error'))
   <script>
    iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    position: 'topRight', 
    });
    iziToast.error({
      title: '',
      position: 'topRight',
      class: 'iziToast-custom',
      message: `{{ Session::get('error') }}`
    });
  </script>
@endif
      <div class="card-body">
        <form action="{{ route('reset.password.post') }}" method="POST">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <!-- Current password -->
          <div class="mb-3 mt-3 row d-flex">
            <label for="current-pw" class="control-label col-sm-4">Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password" name="password">
              @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
              @endif
            </div>
          </div>
          <!-- New password -->
          <div class="mb-3 row d-flex">
            <label for="new-pw" class="control-label col-sm-4">Password Confirmation:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
              @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
              @endif
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