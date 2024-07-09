@extends('layouts.app')

@section('title', 'Register Confirm')

@section('contents')


<div class="row justify-content-center align-items-center h-100">
    <div class="col-lg-6">
        <div class="card-custom" style="border-radius: 15px;">
            <div class="card-header-custom p-3 txtColor">
                Register Confirm
            </div>
            <div class="card-body">
                <form action="{{ route('user.save')}}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <!-- Profile Column -->
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="mb-3">
                               
                                @if(Session::has('profile'))
                                    <img src="{{ asset(Session::get('profile')) }}" alt="Profile Image" class="rounded" width="150" height="150">
                               
                                @endif
                                <input type="hidden" class="form-control mt-2" value="{{ Session::get('profile') }}" name="profile" id="profile" />
                            </div>
                        </div>

                        <!-- Name to Confirm Password Column -->
                        <div class="col-md-4 mb-4 mb-md-0">
                            <!-- Name -->
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Full name" value="{{$user->name}}" name="name" id="name" />
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Email address -->
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email address" value="{{$user->email}}" name="email" id="email" />
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" value="{{$user->pw}}" name="pw" id="pw" />
                                @error('pw')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" value="{{$user->pw_confirmation}}" name="pw_confirmation" id="pw_confirmation" />
                            </div>
                            <!--                            
                            <div class="mb-3 row text-end">
                        <div class="col-md-12">
                            <button type="submit" class="btn btnColor col-sm-5">Register</button>
                            <button type="reset" class="btn btn-secondary col-sm-5">Clear</button>
                        </div>
                    </div>-->


                        </div>

                        <!-- Type to Address Column -->
                        <div class="col-md-4">
                            <!-- Type -->
                            <div class="mb-3">
                                <select name="type" id="type" class="form-select">
                                    <option value="1" {{ $user->type == null ? 'selected' : '' }}>Select Type</option>
                                    <option value="0" {{ $user->type == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>User</option>
                                   
                                    
                                </select>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <input type="phone" class="form-control" placeholder="Phone" value="{{$user->phone}}" name="phone" id="phone" />
                                @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-3">
                                <input type="date" class="form-control" placeholder="DOB" value="{{$user->dob}}" name="dob" id="dob" />
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Address" value="{{$user->address}}" name="address" id="address" />
                                @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btnColor col-sm-5" style="border:none;border-radius:5px;border:1px solid #1a5276;">Confirm</button>
                                <button type="reset" class="btn btnColor btn-secondary col-sm-5 ms-2" onclick="window.history.back();">Cancel</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection