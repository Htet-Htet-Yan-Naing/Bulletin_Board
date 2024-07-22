@extends('layouts.app')
@section('title', 'Edit Profile')
@section('contents') 
<div class="row d-flex justify-content-center align-items-center h-100 mt">
  <div class="col-xl-8">
    <div class="card-custom" style="border-radius: 15px;">
      <div class="card-header-custom p-3 txtColor">
        Profile Edit
      </div>
      <div class="card-body">
      <form method="POST" action="{{ route('updateProfile', $user->id) }}" enctype="multipart/form-data" id="myForm">
      @csrf
      <div class="row">
        <!-- Left column --> 
        <div class="col-md-6">


          <div class="row align-items-center pt-4 pb-3">
            <div class="col-md-4">
              <label class="mb-0">Full name</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name"/>
            </div>
          </div>

          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Email address</label>
            </div>
            <div class="col-md-8">
              <input type="email" class="form-control" placeholder="example@example.com" value="{{ $user->email }}" name="email" id="email"/>
            </div>
          </div>

          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Type</label>
            </div>
            <!--@auth
            <div class="col-md-8">
                    @if(auth()->user()->type == 'admin')
                    <select name="type" id="type" class="form-select">
                       <option value="0" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                       <option value="1" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @endif
                    @if(auth()->user()->type  == 'user')
                    <select name="type" id="type" class="form-select" disabled>
                       <option value="1" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @endif
            </div>
            @endauth-->

            <div class="col-md-8">
    @auth
        @if(auth()->user()->type == 'admin')
            <select name="type" id="type" class="form-select">
                <option value="0" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="1" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
            </select>
        @elseif(auth()->user()->type == 'user')
            <select name="type" id="type" class="form-select">
                <option value="1" {{ $user->type == 'user' ? 'selected' : '' }}>User</option>
            </select>
        @endif
    @endauth
</div>

          </div>


          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Old Profile</label>
            </div>
            <div class="col-md-8">
              <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200" name="profile">
            </div>
          </div>
          
          </div>
          <!-- Left column end -->


          <div class="col-md-6">
          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Phone</label>
            </div>
            <div class="col-md-8">
              <input type="phone" class="form-control" value="{{ $user->phone }}" name="phone" id="phone"/>
            </div>
          </div>
         

          
          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Date of Birth</label>
            </div>
            <div class="col-md-8">
              <input class="form-control" type="date" value="{{ $user->dob }}" name="dob" id="dob"/>
            </div>
          </div>

          <div class="row align-items-center py-3">
            <div class="col-md-4">
              <label class="mb-0">Address</label>
            </div>
            <div class="col-md-8">
              <input class="form-control" type="text" value="{{ $user->address }}" name="address" id="addr"/>
            </div>
          </div>

          



          
         

          <div class="row align-items-center py-3">
                  <div class="col-md-4">
                    <label class="mb-0">New Profile</label>
                  </div>
                  <div class="col-md-8">
                    <input type="file" class="form-control" id="newProfile" name="newProfile"/>
                    @error('newProfile')
                            <span class="text-danger">{{$message}}</span>
                   @enderror
                  </div>
          </div>

          <!-- Button -->
          <div class="row">

            <div class="col-md-12 text-end">

             

              <div class="">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btnColor btn-block col-md-4">Edit</button>
                <button type="button" onclick="resetBtn()" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-md-4">Clear</button>
              </div>
              <br>
              
              <a href="{{ route('change_password', $user->id)}}" data-mdb-button-init data-mdb-ripple-init class="btn-block">Change password</a>
            
            </div>
          </div>

          </div>
          <!-- right column end -->
          </div>
          <!-- row end -->
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function resetBtn() {
        document.getElementById('name').value = " ";
        document.getElementById('email').value = " ";
        document.getElementById('phone').value = " ";
        document.getElementById('dob').value = " ";
        document.getElementById('addr').value = " ";
        document.getElementById('type').value = " ";
        document.getElementById('newProfile').value = '';
    }
</script>
@endsection