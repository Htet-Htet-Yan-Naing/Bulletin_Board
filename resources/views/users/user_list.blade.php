<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User List</title>
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
     <span class="navbar-text text-white">User List</span>
  </div>
</nav>
    <div class="container py-5">
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

<div class="col-md-3 float-start mb-5 ml-5">
  <label class=""> Name: </label>
  <input class="search-btn p-2" type="text" name="name" style="border:1px solid black;border-radius:8px;">
</div>   

<div class="col-md-3 float-start mb-5">
  <label class=""> Email: </label>
  <input class="search-btn p-2" type="email" name="email" style="border:1px solid black;border-radius:8px;">
</div> 

<div class="col-md-3 float-start mb-5">
  <label class=""> From: </label>
  <input class="search-btn p-2" type="date" name="start-date" style="border:1px solid black;border-radius:8px;">
</div> 

<div class="col-md-3 float-start mb-5">
  <label class=""> To: </label>
  <input class="search-btn p-2" type="date" name="end-date" style="border:1px solid black;border-radius:8px;">
</div> 



    <table class="table table-hover table-striped">
        <thead class="table-primary">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created User</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
        @if($users->count() > 0)
                @foreach($users as $rs)
                    <tr>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">{{ $rs->email }}</td>
                        <td class="align-middle">-</td>
                        <td class="align-middle">admin</td>
                        <td class="align-middle">{{ $rs->phone }}</td>
                        <td class="align-middle">{{ $rs->dob }}</td>
                        <td class="align-middle">{{ $rs->address }}</td>
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
    {!! $users->links() !!}
    </div>

    </body>
</html>
