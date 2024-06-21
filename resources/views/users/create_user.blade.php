@extends('layouts.app')
@section('title', 'Login')
@section('contents') 
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Register
            </div>
            <div class="card-body">
              <form action="{{ route('confirmRegister') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center pt-4 pb-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Full name</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="text" class="form-control form-control-lg" name="name" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Email address</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="email" class="form-control form-control-lg" placeholder="example@example.com" name="email" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Password</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="password" class="form-control form-control-lg" name="password" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Confirm Password</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="password" class="form-control form-control-lg" name="password" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Type</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <select name="type" id="" class="form-select">
                      <option value="0">Admin</option>
                      <option value="1">User</option>
                    </select>
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Phone</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="phone" class="form-control form-control-lg" name="phone" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">DOB</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control form-control-lg" id="dd" type="date" name="date" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Address</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input type="phone" class="form-control form-control-lg" name="address" />
                  </div>
                </div>
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Profile</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control form-control-lg" id="formFileLg" type="file" name="profile" />
                    <div class="small text-muted mt-2">Upload your CV/Resume or any other relevant file. Max file
                      size 50 MB</div>
                  </div>
                </div>
                <!-- Button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Register</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endsection