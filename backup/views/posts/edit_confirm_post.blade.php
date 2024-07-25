@extends('layouts.app')
@section('title', 'Edit Confirm Post')
@section('contents')   
     <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header bg-success p-3 text-white">
              Edit Confirm Post
            </div>
            <div class="card-body">
              <form action="{{ route('update', $post->id) }}" method="POST">
                @csrf
                <!-- Email input -->
                <div class="mb-3 mt-3 row d-flex">
                  <label for="email" class="control-label col-sm-3">Title:</label>
                  <div class="col-sm-9"> <input type="text" class="form-control" id="email" name="title" value="{{ $post->title }}"></div>
                </div>
                <!-- Password input -->
                <div class="mb-3 row d-flex">
                  <label for="pwd" class="control-label col-sm-3">Description:</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" rows="5" id="comment" name="description">{{ $post->description }}</textarea>
                  </div>
                </div>
                <div class="row form-inline">
                  <div class="d-flex">
                    <label class="form-check-label col-md-3" for="flexSwitchCheckDefault">Status</label>
                    <div class="col-sm-9 form-switch">
                      <input type="hidden" name="toggle_switch" value="{{$toggleStatus}}">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($toggleStatus == 1) checked @endif>
                    </div>
                  </div>
                </div>
                <br>
                <!-- Submit button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-5">Confirm</button>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-5" onclick="window.history.back();">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection