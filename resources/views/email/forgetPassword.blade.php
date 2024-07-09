<h1>Welcome to Bulletin_Board, {{ $mailData['name'] }} </h1>
<p>Your username is: {{ $mailData['name'] }}</p>
<a href="{{ route('reset.password.get', $mailData['token'] ) }}">
  http://localhost:8000/reset-password/{{ $mailData['token'] }}
</a>
<p>Click the link and reset password.</p>
<p>Thanks for joining and have a great day.</p>
