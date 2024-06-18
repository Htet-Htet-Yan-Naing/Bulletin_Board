@extends('layouts.app')
@section('title', 'Create Post')
 <!-- Changes happen here -->
 @section('contents')
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Create post
            </div>
            <div class="card-body">
              <form action="{{ route('confirmPost') }}" method="get">
                @csrf
                <div class="mb-3 mt-3 row d-flex">
                  <label for="email" class="control-label col-sm-3">Title:</label>
                  <div class="col-sm-9"> 
                    <input type="text" class="form-control" id="email" name="title">
                    @error('title')
                          <span class="text-red-600">{{$message}}</span>
                    @enderror
                  </div>
                </div>
                <div class="mb-3 row d-flex">
                  <label for="pwd" class="control-label col-sm-3">Description:</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" rows="5" id="comment" name="description"></textarea>
                    @error('description')
                          <span class="text-red-600">{{$message}}</span>
                    @enderror
                  </div>
                </div>
                <!-- Submit button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Create</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
                  </div>
                </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      @endsection
<!-- Changes happen here -->