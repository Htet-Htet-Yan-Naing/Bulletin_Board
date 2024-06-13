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
    <nav class="navbar navbar-expand-sm bg-success">
  <div class="container-fluid">
     <span class="navbar-text text-white">Reset Password</span>
  </div>
</nav>
    <div class="container-md col-sm-6 mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-sm-12">

    <div class="card p-3" style="border-radius: 15px;">
          <div class="card-body">

    <form>
  <!-- Current password -->
  <div class="mb-3 mt-5 row d-flex">
      <label for="current-pw" class="control-label col-sm-4">Password:</label>
      <div class="col-sm-8"> <input type="password" class="form-control" id="pw" name="pw"></div>
    </div>

  <!-- New password -->
  <div class="mb-3 row d-flex">
      <label for="new-pw" class="control-label col-sm-4">Password Confirmation:</label>
      <div class="col-sm-8"><input type="password" class="form-control" id="pw-confirm" name="pw-confirm"></div>
    </div>
 
  <!-- Submit button -->
  <div class="row d-flex justify-content-center align-content-center">
  <div class="col-sm-4">
    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block col-sm-12">Update password</button>
</div>
</div>
 
</form>

</div></div>

</div></div>

</div>
    </body>
</html>
