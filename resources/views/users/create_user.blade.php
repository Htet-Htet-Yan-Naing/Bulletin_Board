<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Register</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
        </style>
    </head>

    <body class="antialiased">
      <!--Nav bar -->
      <nav class="navbar navbar-expand-sm navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)">Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button">Search</button>
      </form>
    </div>
  </div>
</nav>



<!--Register -->
<section class="vh-100">
  <div class="container h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-9">

     

        <div class="card" style="border-radius: 15px;">

        <div class="card-header bg-success p-3 text-white">
            Register
        </div>

          <div class="card-body">
          <form action="{{ route('confirmRegister') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row align-items-center pt-4 pb-3">
              <div class="col-md-3 ps-5">
                <h6 class="mb-0">Full name</h6>
              </div>
              <div class="col-md-9 pe-5">

                <input type="text" class="form-control form-control-lg" name="name"/>

              </div>
            </div>

          

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Email address</h6>

              </div>
              <div class="col-md-9 pe-5">

                <input type="email" class="form-control form-control-lg" placeholder="example@example.com" name="email"/>

              </div>
            </div>

           

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Password</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="password" class="form-control form-control-lg" name="password"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Confirm Password</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="password" class="form-control form-control-lg" name="password"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Type</h6>

              </div>
              <div class="col-md-9 pe-5">

              <select name="type" id="" class="form-select" >
          <option value="0">Admin</option>
          <option value="1">User</option>
        </select>

              </div>
            </div>








            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Phone</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="phone" class="form-control form-control-lg" name="phone"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">DOB</h6>

              </div>
              <div class="col-md-9 pe-5">
              <input class="form-control form-control-lg" id="dd" type="date" name="date"/>
              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Address</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="phone" class="form-control form-control-lg" name="address"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Profile</h6>

              </div>
              <div class="col-md-9 pe-5">

                <input class="form-control form-control-lg" id="formFileLg" type="file" name="profile"/>
                <div class="small text-muted mt-2">Upload your CV/Resume or any other relevant file. Max file
                  size 50 MB</div>

              </div>
            </div>
              <!-- Button -->
  <div class="row d-flex justify-content-center align-content-center">
  <div class="col-sm-6">
    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Register</button>
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
