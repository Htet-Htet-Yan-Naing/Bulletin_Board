@extends('layouts.app')
@section('title', 'Login')
 @section('contents')
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-7">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Login
            </div>
            <div class="card-body text-center">
            <form action="{{ route('login.action') }}" method="post">
            @csrf
              <!-- Email input -->
              <div class="mb-3 mt-3 row justify-content-center align-items-center">
                    <label for="email" class="control-label col-md-2 text-md-end">Email:</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
                        @error('email')
                          <span class="text-red-600">{{$message}}</span>
                        @enderror
                      </div>
                </div>

                <!-- Password input -->
                <div class="mb-3 mt-3 row justify-content-center align-items-center">
                    <label for="password" class="control-label col-md-2 text-md-end">Password:</label>
                    <div class="col-md-8">
                      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="{{ old('password') }}">
                      @error('password')
                          <span class="text-red-600">{{$message}}</span>
                      @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-3"></div>
                  <div class="col-md-4 d-flex ">
                    <!-- Remember me Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                      <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                  </div>

                  <!--Forgot password? link -->
                  <div class="col-md-4">
                    <a href="#!">Forgot password?</a>
                  </div>
                </div>
               
                <!-- Submit button -->
                <div class="mb-3 mt-3 row justify-content-center align-items-center">
                    <div class="col-md-2"></div>
                      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-md-8">Log In</button>
                </div>

                <!-- Register buttons -->
                <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
                    <div class="col-md-2"></div>
                    <p class="mb-0 d-flex align-items-center justify-content-center">
                        Create account? 
                        <a href="#!" class="ms-2 d-inline-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            </svg>
                        </a>
                    </p>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
@endsection
  