@extends('layouts.app')
@section('title', 'Create Confirm Post')
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-6">
    <div class="card" style="border-radius: 15px;">
      <div class="card-header bg-success p-3 text-white">
        Confirm Post
      </div>
      <div class="card-body">
        <form action="{{ route('post.save') }}" method="POST">
          @csrf
          <!-- Email input -->
          <div class="mb-3 mt-3 row d-flex">
            <label for="email" class="control-label col-sm-3">Title:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="title" name="title" value="{{ $title }}">
              @error('title')
          <span class="text-red-600">{{$message}}</span>
        @enderror
            </div>

          </div>
          <!-- Password input -->
          <div class="mb-3 row d-flex">
            <label for="pwd" class="control-label col-sm-3">Description:</label>
            <div class="col-sm-9">
              <textarea class="form-control" rows="5" id="description" name="description">{{ $description }}</textarea>
              @error('description')
          <span class="text-red-600">{{$message}}</span>
        @enderror
            </div>
          </div>
          <!-- Submit button -->
          <div class="row d-flex justify-content-center align-content-center">
            <div class="col-sm-6">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-5">Confirm</button>
              <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-5" id="resetBtn" onclick="history.back()">Cancel</button>
              </form>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection