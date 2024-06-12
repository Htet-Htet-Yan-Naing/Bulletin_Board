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
    <nav class="navbar navbar-expand-sm bg-success">
  <div class="container-fluid">
     <span class="navbar-text text-white">Profile</span>
  </div>
</nav>



<!--Profile -->
<section class="vh-100">
  <div class="container h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-xl-8 ">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body">
          <form method="GET">
          @csrf
          <!-- float:left -->
          <div class="row align-items-center py-3 float-start col-md-4">
              <div class="col-md-3 ps-12">
              </div>
              <div class="col-md-9 pe-5">
              <img src="{{asset($imagePath)}}" alt="error" class="rounded" width="200" height="200" name="profile">
              </div>
            </div>
   
          <!-- float:right -->
          <div class="float-end col-md-8 ps-5">
          <div class="row align-items-center py-3 ">
              <div class="col-md-3 ">
              <label class="mb-0">Name</label>
              </div>
              <div class="col-md-9">
              <label class="control-label col-sm-12" name="name">{{ $user->name }}</label>
              </div>
            </div>
            <div class="row align-items-center py-3">
              <div class="col-md-3">
              <label class="mb-0">Email</label>
              </div>
              <div class="col-md-9">
              <label class="control-label col-sm-12" name="email">{{ $user->email }}</label>
              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3">
              <label class="mb-0" >Phone</label>
              </div>
              <div class="col-md-9">
              <label class="control-label col-sm-12" name="phone">{{ $user->phone }}</label>
              </div>
            </div>


            <div class="row align-items-center py-3">
              <div class="col-md-3" >

              <label class="mb-0">DOB</label>

              </div>
              <div class="col-md-9">
              <label class="control-label col-sm-12" name="dob">{{ $user->dob }}</label>
              </div>
            </div>

            <div class="row align-items-center py-3">
              <div class="col-md-3" >

              <label class="mb-0">Address</label>

              </div>
              <div class="col-md-9 ">
              <label class="control-label col-sm-12" name="address">{{ $user->address }}</label>
              </div>
            </div>

                          <!-- Button -->
  
 
  <a href="{{ route('editProfile', $user->id)}}" type="button" class="btn btn-success">Edit profile</a>



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
