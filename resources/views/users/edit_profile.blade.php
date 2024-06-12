<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile Edit</title>
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
     <span class="navbar-text text-white">Profile Edit</span>
  </div>
</nav>



<!--Register -->
<section class="vh-100">
  <div class="container h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-9">

     

        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
            

          <form action="{{ route('confirmRegister') }}" method="POST">
          @csrf



          <div class="row align-items-center pt-4 pb-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Full name</h6>

              </div>
              <div class="col-md-9 pe-5">

                <input type="text" class="form-control form-control-lg" value="{{ $user->name }}"/>

              </div>
            </div>

          

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Email address</h6>

              </div>
              <div class="col-md-9 pe-5">

                <input type="email" class="form-control form-control-lg" placeholder="example@example.com" value="{{ $user->email }}"/>

              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Password</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="password" class="form-control form-control-lg" value="{{ $user->password }}"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Confirm Password</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="password" class="form-control form-control-lg" value="{{ $user->password }}"/>

              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">
                <h6 class="mb-0">Type</h6>
              </div>
              <div class="col-md-9 pe-5">
              <select name="type" id="" class="form-select">
          <option>Admin</option>
          <option>User</option>
        </select>
              </div>
            </div>



            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Phone</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="phone" class="form-control form-control-lg" value="{{ $user->phone }}"/>

              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Date of Birth</h6>

              </div>
              <div class="col-md-9 pe-5">
              <input class="form-control form-control-lg" id="dd" type="date" name="date" value="{{ $user->dob }}"/>
              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

                <h6 class="mb-0">Address</h6>

              </div>
              <div class="col-md-9 pe-5">

              <input type="phone" class="form-control form-control-lg" value="{{ $user->address }}"/>

              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3 ps-5">

              <h6 class="mb-0">Old Profile</h6>

              </div>
              <div class="col-md-9 pe-5">

              <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200" name="profile">

              </div>
            </div>

              <!-- Button -->
  <div class="row d-flex justify-content-center align-content-center">
  <div class="col-sm-6">
    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-3">Register</button>
  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-3">Clear</button>
  <a href="#" data-mdb-button-init data-mdb-ripple-init class="btn-block col-sm-7">Change password</a>
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
