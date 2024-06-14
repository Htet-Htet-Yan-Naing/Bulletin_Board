<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Post List</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .nav-link {
      padding: 0;
    }

    .dropdown-menu {
      margin: .5rem -7.5rem;
    }
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
          <a class="nav-link text-success" href="#">Create User</a>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-gear text-success" viewBox="0 0 16 16">
        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
      </svg>
      <div class="dropdown">
        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"></button>
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
  @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
    </div>
  @endif
  <section>
    <div class="container mt-5">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-12">
          <div class="card" style="border-radius: 15px;">
            <div class="card-header bg-success p-3 text-white">
              Post List
            </div>
            <div class="card-body">
              <div class="float-end">
                <div class="container py-5">
                  <label class=""> Keyword: </label>
                  <input class="search-btn p-2" type="text" name="search-keyword" placeholder="Type Something" style="border:1px solid black;border-radius:8px;">
                  <button type="button" class="btn btn-success btn-lg">Search</button>
                  <button type="button" class="btn btn-success btn-lg">Create</button>
                  <button type="button" class="btn btn-success btn-lg">Upload</button>
                  <button type="button" class="btn btn-success btn-lg">Download</button>
                </div>
              </div>
              <div class="container py-5">
                <table class="table table-hover table-striped">
                  <thead class="table-primary">
                    <tr>
                      <th>Post Title</th>
                      <th>Post Description</th>
                      <th>Posted User</th>
                      <th>Posted Date</th>
                      <th>Operation</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($posts->count() > 0)
            @foreach($posts as $rs)
        <tr>
          <td class="align-middle">{{ $rs->title }}</td>
          <td class="align-middle">{{ $rs->description }}</td>
          <td class="align-middle">admin</td>
          <td class="align-middle">{{ $rs->created_at }}</td>
          <td class="align-middle">

          <a href="{{ route('edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
          <form action="#" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger m-0">Delete</button>
          </form>

          </td>
        </tr>
      @endforeach
          @else
      <tr>
        <td class="text-center" colspan="5">Product not found</td>
      </tr>
    @endif
                  </tbody>
                </table>
                {!! $posts->links() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>