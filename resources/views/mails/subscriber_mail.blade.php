<!DOCTYPE html>
<html>
<head>
    <title>Subscriber Email</title>
</head>
<body>
 <h1>Hello dear {{$details['subscriber']['name']}}</h1>
<p>In website {{$details['post']['website']['name']}} added new post</p>

 <div style="border: 1px solid red; background-color: #0dcaf0; color: #333; padding: 20px; border-radius: 10px">
     <h1>{{$details['post']['title']}}</h1>
     <p>{{$details['post']['description']}}</p>
 </div>

</body>
</html>
