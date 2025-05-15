<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
</head>
<body>
    
    @foreach ($authors as $author)
    <ul>
        <li>id: {{$author['id'] }}</li>
        <li>name: {{$author['name'] }}</li>
        <li>photo: {{$author['photo'] }}</li>
        <li>bio: {{$author['bio'] }}</li>
    </ul>
        
    @endforeach


</body>
</html>