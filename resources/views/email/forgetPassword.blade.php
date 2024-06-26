<h1>Welcome to Bulletin_Board, {{$name}} </h1>
<p>Your username is: {{$name}}</p>
<a href="{{ route('reset.password.get', $token) }}">
  http://localhost:8000/reset-password/{{$token}}
</a>
<p>Click the link and reset password.</p>
<p>Thanks for joining and have a great day.</p>
