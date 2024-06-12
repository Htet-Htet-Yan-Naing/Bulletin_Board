<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Upload CSV file</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
        </style>
    </head>

    <body class="antialiased">
      <!--Nav bar -->
    <nav class="navbar navbar-expand-sm bg-success">
  <div class="container-fluid">
     <span class="navbar-text text-white">Upload CSV file</span>
  </div>
</nav>



<!--Register -->
<section class="vh-100">
  <div class="container h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-xl-9">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
          <form action="{{ route('confirmRegister') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">CSV file</h6>

              </div>
              <div class="col-md-9 pe-5">

                <input class="form-control form-control-lg" id="formFileLg" type="file" name="profile"/>
             

              </div>
            </div>
              <!-- Button -->
  <div class="row d-flex justify-content-center align-content-center">
  <div class="col-sm-6">
    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Upload</button>
  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
</div>
</div>
          </form>

          </div>
        </div>

      </div>
    </div>

  </div>
</section>
    
    </body>
   
</html>
