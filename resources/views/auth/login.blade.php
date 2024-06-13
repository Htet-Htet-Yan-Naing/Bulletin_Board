<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
        </style>
    </head>
    <body class="antialiased">
    <!-- Navigation bar start -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand text-success" href="#">Bulletin_Board</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-success" href="#">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-success" href="#">Posts</a>
        </li>
      </ul>
      <form class="d-flex align-items-center">
        <a class="nav-link text-success" href="#">Create User</a></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-gear text-success" viewBox="0 0 16 16">
  <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
</svg>
<div class="dropdown">
    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" ></button>
    <ul class="dropdown-menu dropdown-menu-left">
      <li><a class="dropdown-item" href="#">Profile</a></li>
      <li><a class="dropdown-item" href="#">Logout</a></li>
    </ul>
  </div>
      </form>
    </div>
  </div>
</nav>
 <!-- Navigation bar end -->
 <section>
  <div class="container mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-6">
        <div class="card" style="border-radius: 15px;">
        <div class="card-header bg-success p-3 text-white">
          Login
        </div>
          <div class="card-body">
    <form>
  <!-- Email input -->
  <div class="mb-3 mt-5 row d-flex">
      <label for="email" class="control-label col-sm-3">Email:</label>
      <div class="col-sm-9"> <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"></div>
    </div>

  <!-- Password input -->
  <div class="mb-3 row d-flex">
      <label for="pwd" class="control-label col-sm-3">Password:</label>
      <div class="col-sm-9"><input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd"></div>
    </div>

  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
        <label class="form-check-label" for="form2Example31"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div>

  <!-- Submit button -->
  <div class="row">
  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-12">Log In</button>
</div>
  <!-- Register buttons -->
  <div class="text-center">
    <p>Create account? <a href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg></a></p>
    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-facebook-f"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-google"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-twitter"></i>
    </button>

    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
      <i class="fab fa-github"></i>
    </button>
  </div>
</form>

</div></div>

</div></div>

</div>
    </body>
</html>
