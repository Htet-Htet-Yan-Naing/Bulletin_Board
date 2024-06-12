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
  <nav class="navbar navbar-expand-sm bg-success">
    <div class="container-fluid">
      <span class="navbar-text text-white">Edit Post</span>
    </div>
  </nav>
  <div class="container-md col-sm-4">
    <form action="{{ route('confirmEdit', $posts->id) }}" method="POST">
      @csrf
      <!-- Email input -->
      <div class="mb-3 mt-5 row d-flex">
        <label for="email" class="control-label col-sm-3">Title:</label>
        <div class="col-sm-9"> <input type="text" class="form-control" id="email" name="title" value="{{ $posts->title }}"></div>
      </div>
      <!-- Password input -->
      <div class="mb-3 row d-flex">
        <label for="pwd" class="control-label col-sm-3">Description:</label>
        <div class="col-sm-9">
          <textarea class="form-control" rows="5" id="comment" name="description">{{ $posts->description }}</textarea>
        </div>
      </div>

      <div class="row form-inline">
        <div class="d-flex">
          <label class="form-check-label col-md-3" for="flexSwitchCheckDefault">Status</label>
          <div class="col-sm-9 form-switch">
          <input type="hidden" name="toggle_switch" value="1">
          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
          </div>
        </div>
      </div>
      <br>

      <!-- Submit button -->
      <div class="row d-flex justify-content-center align-content-center">
        <div class="col-sm-6">
          <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-block col-sm-4">Edit</button>
          <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-secondary btn-block col-sm-4">Clear</button>
        </div>
      </div>
    </form>
  </div>

  <script>
document.addEventListener('DOMContentLoaded', function () {
    var switchToggle = document.getElementById('flexSwitchCheckDefault');
    var hiddenInput = document.querySelector('input[name="toggle_switch"]');
    
    switchToggle.addEventListener('change', function () {
        hiddenInput.value = this.checked ? 1 : 0;
    });
});
</script>
</body>

</html>