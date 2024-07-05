@extends('layouts.app')
@section('title', 'Create Post')
@section('contents')
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-6">
    <div class="card-custom">
      <div class="card-header-custom p-3 txtColor">
        Create Post
      </div>
      <div class="card-body">
        <form action="{{ route('confirmPost') }}" method="get">
          @csrf
           <!-- Title -->
          <div class="mb-3 mt-3 row d-flex">
            <label for="email" class="control-label col-sm-3">Title:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
              @error('title')
          <span class="text-danger mt-3">{{$message}}</span>
        @enderror
            </div>
          </div>
           <!-- Description -->
          <div class="mb-3 row d-flex">
            <label for="pwd" class="control-label col-sm-3">Description:</label>
            <div class="col-sm-9">
              <textarea class="form-control" rows="5" id="description" name="description" value="">{{ old('description') }}</textarea>
              @error('description')
          <span class="text-danger mt-3">{{$message}}</span>
        @enderror
            </div>
          </div>
          <!-- Submit button -->
          <div class="row d-flex justify-content-center align-content-center">
            <div class="col-sm-6">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btnColor btn-block col-sm-4">Create</button>
              <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4" id="resetBtn">Clear</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var resetButton = document.getElementById('resetBtn');
    resetButton.addEventListener('click', function () {
      document.getElementById('title').value = "  ";
      document.getElementById('description').value = " ";
    });
  });
</script>
@endsection