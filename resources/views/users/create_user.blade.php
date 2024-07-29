@extends('layouts.app')
@section('title', 'Register')
@section('contents') 

<div class="row justify-content-center align-items-center h-100 mt">
    <div class="col-lg-6">
        <div class="card-custom" style="border-radius: 15px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
            <div class="card-header-custom p-3 txtColor">
                Register
            </div>
            <div class="card-body">
                <form action="{{route('confirmRegister')}}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Full name -->
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Full name" id="name" name="name" value="{{ old('name') }}" />
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Email address -->
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email address" id="email" name="email" value="{{ old('email') }}" />
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" id="pw" name="pw" value="{{ old('pw') }}" />
                                @error('pw')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" id="pw_confirmation" name="pw_confirmation" value="{{ old('pw_confirmation') }}" />
                                @error('pw_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Type (conditionally shown based on authentication) -->
                            @auth
                                <div class="mb-3">
                                    <div>
                                        @if(auth()->user()->type == 'admin')
                                            <select name="type" id="type" class="form-select">
                                                <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>User</option>
                                                <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        @elseif(auth()->user()->type == 'user')
                                            <select name="type" id="type" class="form-select">
                                                <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>User</option>
                                            </select>
                                        @else
                                            <p>Unknown role</p>
                                        @endif
                                    </div>
                                </div>
                            @endauth
                            <!-- Phone -->
                            <div class="mb-3">
                                <input type="phone" class="form-control" placeholder="Phone" id="phone" name="phone" value="{{ old('phone') }}" />
                                @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <!-- DOB -->
                            <div class="mb-3">
                                <input class="form-control" placeholder="DOB" id="dob" type="date" name="dob" value="{{ old('dob') }}" />
                            </div>
                            <!-- Address -->
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Address" id="address" name="address" value="{{ old('address') }}" />
                                @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Profile -->
                    <div class="mb-3 col-md-12">
                        <input type="file" class="form-control" placeholder="profile" id="profile" name="profile"/>
                        @error('profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btnColor col-sm-2" id="register">Register</button>
                            <button type="reset" class="btn btn-secondary col-sm-2">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(Session::has('error'))
  <script>
    iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    position: 'topRight',
    });
    document.addEventListener('DOMContentLoaded', function () {
    iziToast.error({
      title: '',
      position: 'topRight',
      class: 'iziToast-custom',
      message: `{{ Session::get('error') }}`
    });
    });
  </script>
@endif 
@endsection