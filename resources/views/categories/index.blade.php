<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>

<h1>Liste des catégories</h1>

<a href="{{ route('categories.create') }}">
    Ajouter une catégorie
</a>

<hr>

@foreach($categories as $category)
    <p>{{ $category->name }}</p>
@endforeach

</body>
</html>