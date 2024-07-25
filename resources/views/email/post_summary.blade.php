@component('mail::message')
<!DOCTYPE html>
<html>
<head>
    <title>Daily Post Summary</title>
</head>
<body>
    <h2>{{$posts}}</h2>
    <p>Here are the 10 latest active status posts from yesterday:</p>
    <ul>
        @foreach($posts as $post)
        <li>{{ $post->title }}</li>
        @endforeach
    </ul>
</body>
</html>
@endcomponent