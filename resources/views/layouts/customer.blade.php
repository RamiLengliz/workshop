<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('title', 'Workshop Bistro')</title>
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body class="customer">
    @yield('content')

    <script src="{{ asset('js/customer.js') }}" defer></script>
</body>
</html>
