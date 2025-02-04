<!DOCTYPE html>
<html>
<head>
    <title>Subscriber Email</title>
</head>
<body>
<h1>Hello dear {{ $subscriber->name ?? 'Subscriber' }}</h1>
<p>In website {{ $post->website->name ?? 'Unknown Website' }} added new post</p>

<div style="border: 1px solid red; background-color: #0dcaf0; color: #333; padding: 20px; border-radius: 10px">
    <h1>{{ $post->title ?? 'No Title' }}</h1>
    <p>{{ $post->description ?? 'No Description' }}</p>
</div>


</body>
</html>
