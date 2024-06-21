@extends('layouts.app')
@section('title', 'Login')
@section('contents') 
@if(Session::has('success'))
  <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
  </div>
@endif
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-xl-12">
    <div class="card" style="border-radius: 15px;">
      <div class="card-header bg-success p-3 text-white">
        User List
      </div>
      <div class="card-body">
        <div class="container py-5">
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

        <a href="{{ route('profile', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
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
    </div>
  </div>
</div>
@endsection