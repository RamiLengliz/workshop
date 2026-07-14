<!DOCTYPE html>
<html>
<head>
    <title>Ajouter catégorie</title>
</head>
<body>

<h1>Ajouter une catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <input
        type="text"
        name="name"
        placeholder="Nom catégorie">

    <button type="submit">
        Enregistrer
    </button>
</form>

</body>
</html>