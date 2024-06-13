<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create post</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
        </style>
    </head>
    <body class="antialiased">
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

    <div class="container-md col-md-5 mt-5">

    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-12">

    <div class="card p-3" style="border-radius: 15px;">
          <div class="card-body">




    <form action="{{ route('confirmPost') }}" method="POST">
    @csrf
  <!-- Email input -->
  <div class="mb-3 mt-5 row d-flex">
      <label for="email" class="control-label col-sm-3">Title:</label>
      <div class="col-sm-9"> <input type="text" class="form-control" id="email" name="title"></div>
    </div>
  <!-- Password input -->
  <div class="mb-3 row d-flex">
      <label for="pwd" class="control-label col-sm-3">Description:</label>
      <div class="col-sm-9">
      <textarea class="form-control" rows="5" id="comment" name="description"></textarea>
      </div>
    </div>

  <!-- Submit button -->
  <div class="row d-flex justify-content-center align-content-center">
  <div class="col-sm-6">
    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Create</button>
  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
</div>
</div>


</div></div>
</div></div>

</form>
</div>
</body>
</html>
