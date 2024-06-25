@extends('layouts.app')
@section('title', 'Upload CSV File')
@section('contents') 
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Upload CSV File
            </div>
            @if(Session::has('error'))
            <div class="alert alert-success" role="alert">
              {{ Session::get('error') }}
            </div>
            @endif
            <div class="card-body">
              <form action="{{ route('posts.uploadCSV') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">CSV file:</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control form-control-lg" id="formFileLg" type="file" name="csvfile" />
                      @error('csvfile')
                        <span class="text-red-600">{{$message}}</span>
                      @enderror
                  </div>
                </div>
                <!-- Button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Upload</button>
                    <button type="clear" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection