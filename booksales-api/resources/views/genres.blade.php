<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genres
    </title>
</head>
<body>

    @foreach ($genres as $genre)
    <ul>
        <li>id: {{$genre['id'] }}</li>
        <li>name: {{$genre['name'] }}</li>
        <li>description: {{$genre['description'] }}</li>
    </ul>
        
    @endforeach
    
</body>
</html>