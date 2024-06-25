<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .nav-link {
      padding: 0;
    }

    .dropdown-menu {
      margin: .5rem -7.5rem;
    }

    .delete-post-btn:hover {
      opacity: 1;
    }

    /* Float cancel and delete buttons and add an equal width */
    .cancelbtn,
    .deletebtn {
      float: left;
      width: 50%;
    }

    /* Add a color to the cancel button */
    .cancelbtn {
      background-color: #ccc;
      color: black;
    }

    .deletebtn {
      background-color: #f44336;
    }

    .container {
      padding: 16px;
    }
  </style>
</head>

<body>
  <!-- Navigation bar start -->

  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand text-success" href="#">Bulletin_Board</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a class="nav-link text-success" href="{{ route('admin.userList') }}">Users</a>
    @else
    <a class="nav-link text-success" href="{{ route('user.userList') }}">Users</a>
  @endif
        </li>
      @endauth
          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a class="nav-link text-success" href="{{ route('admin.postList') }}">Posts</a>
    @else
    <a class="nav-link text-success" href="{{ route('user.postList') }}">Posts</a>
  @endif
        </li>
      @endauth
        </ul>
        <!-- Displayed if the user is authenticated start-->
        @auth
      <form class="d-flex align-items-center">
        <a class="nav-link text-success" href="{{ route('register') }}">Create User</a>
        <a class="nav-link text-success ms-3" href="#">{{ auth()->user()->name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-gear text-success" viewBox="0 0 16 16">
        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
        </svg>
        <div class="dropdown">
        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"></button>
        <ul class="dropdown-menu dropdown-menu-left">
          <li><a class="dropdown-item" href="{{ route('editProfile', auth()->user()->id) }}">Profile</a></li>
          <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
        </ul>
        </div>
      </form>
    @endauth
        <!-- Displayed if the user is authenticated end-->

        <!-- Displayed if the user is not authenticated start-->
        @guest          <a class="nav-link text-success ms-0" href="{{ route('login') }}">Login</a>
      <a class="nav-link text-success ms-3" href="{{ route('signup') }}">Sign up</a>
    @endguest
        <!-- Displayed if the user is not authenticated end-->
      </div>
    </div>
  </nav>
  <!-- Navigation bar end -->
  <section>
    <div class="container mt-5 mb-5">
      <div>@yield('contents')</div>
    </div>
  </section>
  <!-- Footer start -->
  <footer class="bg-light text-success pt-3 pb-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <p>
          Seattle consulting Myanmar
        </p>
      </div>
      <div class="col-md-6 text-end">
        <p>
          Copyright © Seattle consulting Myanmar Co., Ltd. All rights reserved.
        </p>
      </div>
    </div>
  </div>
  </footer>
   <!-- Footer end -->
</body>

</html>