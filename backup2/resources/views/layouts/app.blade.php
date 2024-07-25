<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
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
      <a class="navbar-brand nav-link" href="{{ route('admin.postList') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
    @else
      <a class="navbar-brand nav-link" href="{{ route('user.postList') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
    @endif
    @endauth
      @guest
      <a class="navbar-brand nav-link pt-2 pb-2" href="{{ route('posts') }}" style="color:#1A5276;font-weight:bold;">Bulletin_Board</a>
      <a class="ms-3 txtColor nav-link {{ request()->routeIs('posts') ? 'nav-active' : '' }}" href="{{ route('posts') }}">Posts</a>
    @endguest
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a href="{{ route('admin.userList') }}" class="txtColor link {{ request()->routeIs('admin.userList') ? 'nav-active' : '' }}">Users</a>
    @else
    <a href="{{ route('user.userList') }}" class="txtColor link {{ request()->routeIs('user.userList') ? 'nav-active' : '' }}">Users</a>
  @endif
        </li>
      @endauth
          @auth
        <li class="nav-item">
        @if(auth()->user()->type == 'admin')
      <a href="{{ route('admin.postList') }}" class="ms-3 txtColor link {{ request()->routeIs('admin.postList') ? 'nav-active' : '' }}" >Posts</a>
    @else
    <a href="{{ route('user.postList') }}" class="ms-3 txtColor link {{ request()->routeIs('user.postList') ? 'nav-active' : '' }}">Posts</a>
  @endif
        </li>
      @endauth
        </ul>
        <!-- Displayed if the user is authenticated start-->
        @auth
      <form class="d-flex align-items-center">
        <a class="ms-3 txtColor nav-link {{ request()->routeIs('register') ? 'nav-active' : '' }}" href="{{ route('register') }}">Create User</a>
        <a class="ms-3 txtColor profile-name nav-link {{ request()->routeIs('profile') ? 'nav-active' : '' }}" href="#">{{ auth()->user()->name }}</a>
        <div class="icon" style="width:27px;height:27px;margin-left:5px;">
        <img src="../{{auth()->user()->profile}}" class="profile-img" alt="Profile">
        </div>
        <div class="dropdown">
        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"></button>
        <ul class="dropdown-menu dropdown-menu-left">
          <li><a class="dropdown-item ms-3 pb-2 txtColor nav-link" href="{{ route('profile', auth()->user()->id) }}">Profile</a></li>
          <li><a class="dropdown-item ms-3 pb-2 txtColor nav-link" href="{{ url('/logout') }}">Logout</a></li>
        </ul>
        </div>
      </form>
    @endauth
        <!-- Displayed if the user is authenticated end-->
        <!-- Displayed if the user is not authenticated start-->
        @guest          <a class="ms-0 txtColor navbar-link nav-link {{ request()->routeIs('login') ? 'nav-active' : '' }}" href="{{ route('login') }}">Login</a>
      <a class="ms-3 txtColor navbar-link nav-link {{ request()->routeIs('signup') ? 'nav-active' : '' }}" href="{{ route('signup') }}">Sign up</a>
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
  <!--<script>
// Add active class to the current button (highlight it)

  var header = document.getElementById("nav");
var btns = header.getElementsByClassName("navbar-link");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    
  var current = document.getElementsByClassName("navbar-active");
  current[0].className = current[0].className.replace(" navbar-active", "");
  this.className += " navbar-active";

  });

}



</script>-->
<!--<script>
document.addEventListener("DOMContentLoaded", function() {
    var header = document.getElementsByClassName("navbar-link");
    var btns = header.getElementsByClassName("nav");

    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            // Remove active class from current active element
            var current = header.getElementsByClassName("navbar-active");
            if (current.length > 0) {
                current[0].classList.remove("navbar-active");
            }
            // Add active class to clicked element
            this.classList.add(" navbar-active");
        });
    }
});
</script>-->
<!--<script>
document.addEventListener("DOMContentLoaded", function() {
    // Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = document.getElementsByClassName("link");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
});
</script>-->
<script>
//document.addEventListener('DOMContentLoaded', function() {
//    // Get the current path of the URL
//    var currentPath = window.location.pathname;
//
//    // Find all navigation links
//    //var navLinks = document.querySelectorAll('.nav-item a');
//    var link=this.getElementsByClassName('link');
//    // Loop through each navigation link
//    //navLinks.forEach(function(link) {
//        // Check if the link's href matches the current path
//        if (link.getAttribute('href') === currentPath) {
//            // Add 'active' class to the link
//            link.classList.add('active');
//        } else {
//            // Remove 'active' class if it's not the current path
//            link.classList.remove('active');
//        }
//    //});
//});
</script>
</body>

</html>