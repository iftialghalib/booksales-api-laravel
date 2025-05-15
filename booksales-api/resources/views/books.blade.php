<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    @foreach ($books as $book)

    <ul>
        <li>id :{{$book['id'] }}</li>
        <li>title: {{$book['title'] }}</li>
        <li>description: {{$book['description'] }}</li>
        <li>price: {{$book['price'] }}</li>
        <li>stock: {{$book['stock'] }}</li>
        <li>cover: {{$book['cover'] }}</li>
        <li>genre_id: {{$book['genre_id'] }}</li>
        <li>author_id: {{$book['author_id'] }}</li>
    </ul>
        
    @endforeach

</body>
</html>