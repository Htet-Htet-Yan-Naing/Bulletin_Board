@extends('layouts.app')
@section('title', 'Upload CSV File')
@section('contents') 
      <div class="row d-flex justify-content-center align-items-center h-100 mt">
        <div class="col-xl-6">
          <div class="card-custom">
            <div class="card-header-custom p-3 txtColor">
              Upload CSV File
            </div>
            @if(Session::has('success'))
  <script>
    iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    position: 'topRight', 
    });
    document.addEventListener('DOMContentLoaded', function () {
    iziToast.success({
      title: '',
      position: 'topRight',
      class: 'iziToast-custom',
      message: `{{ Session::get('success') }}`
    });
    });
  </script>
   @elseif(Session::has('error'))
   <script>
    iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    position: 'topRight', 
    });
    iziToast.error({
      title: '',
      position: 'topRight',
      class: 'iziToast-custom',
      message: `{{ Session::get('error') }}`
    });
  </script>
@endif 
            <div class="card-body">
              <form action="{{ route('posts.uploadCSV') }}" method="POST" enctype="multipart/form-data">
                @csrf
                 <!-- CSV File -->
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <label class="mb-0">CSV file:</label>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input class="form-control form-control-lg" id="csvfile" type="file" name="csvfile"/>
                      @error('csvfile')
                        <span class="text-red-600">{{$message}}</span>
                      @enderror
                  </div>
                </div>
                <!-- Button -->
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col-sm-6">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4" id="upload">Upload</button>
                    <button type="reset" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
  //document.addEventListener("DOMContentLoaded", function () {
  //  var successAlert = document.getElementById('success-alert');
  //  if (successAlert) {
  //    setTimeout(function () {
  //      successAlert.remove();
  //      location.reload();
  //    }, 4000);
  //  }
  //});
  </script>
@endsection