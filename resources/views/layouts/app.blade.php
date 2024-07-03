<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    {!! file_get_contents(public_path('css/style.css')) !!}
    {!! file_get_contents(public_path('css/reset.css')) !!}
  </style>
</head>

<body>
  <!-- Navigation bar start -->
  <nav class="navbar navbar-expand-sm navbar-light header bg-white">
    <div class="container-fluid">
      @auth
      @if(auth()->user()->type == 'admin')
      <a class="navbar-brand" href="{{ route('admin.postList') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
    @else
      <a class="navbar-brand" href="{{ route('user.postList') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
    @endif
    @endauth
      @guest
      <a class="navbar-brand" href="{{ route('posts') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
      <a class="ms-3 txtColor" href="{{ route('posts') }}">Posts</a>
    @endguest
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">




          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a class="txtColor" href="{{ route('admin.userList') }}">Users</a>
    @else
    <a class="txtColor" href="{{ route('user.userList') }}">Users</a>
  @endif
        </li>
      @endauth









          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a class="ms-3 txtColor" href="{{ route('admin.postList') }}">Posts</a>
    @else
    <a class="ms-3 txtColor" href="{{ route('user.postList') }}">Posts</a>
  @endif
        </li>
      @endauth
        </ul>
        <!-- Displayed if the user is authenticated start-->
        @auth
      <form class="d-flex align-items-center">
        <a class="ms-3 txtColor" href="{{ route('register') }}">Create User</a>
        <a class="ms-3 txtColor" href="#">{{ auth()->user()->name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-gear txtColor" viewBox="0 0 16 16">
        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
        </svg>
        <div class="dropdown">
        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"></button>
        <ul class="dropdown-menu dropdown-menu-left">
          <li><a class="dropdown-item ms-3 txtColor" href="{{ route('profile', auth()->user()->id) }}">Profile</a></li>
          <li><a class="dropdown-item ms-3 txtColor" href="{{ url('/logout') }}">Logout</a></li>
        </ul>
        </div>
      </form>
    @endauth
        <!-- Displayed if the user is authenticated end-->

        <!-- Displayed if the user is not authenticated start-->
        @guest  
        <a class="ms-0 txtColor" href="{{ route('login') }}">Login</a>
      <a class="ms-3 txtColor" href="{{ route('signup') }}">Sign up</a>
    @endguest
        <!-- Displayed if the user is not authenticated end-->
      </div>
    </div>
  </nav>
  <!-- Navigation bar end -->
  <main>
    <section class="main-sec">
      <div class="post-list-container">
        <div>@yield('contents')</div>
      </div>
    </section>
  </main>
  <!-- Footer start -->
  <footer class="text-success footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 txtColor">
          <p>
            Metateam Myanmar
          </p>
        </div>
        <div class="col-md-6 text-end txtColor">
          <p>
            Copyright © Metateam Myanmar Co., Ltd. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end -->

</body>

</html>