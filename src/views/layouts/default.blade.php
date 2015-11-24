<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Filmoteca')</title>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/packages/filmoteca/static-pages/stylesheets/menu-creator.css') }}">
</head>
<body>
    <div class="container-fluid">

        @include('filmoteca/static-pages::partials.flashes')

        @yield('content')
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('/packages/filmoteca/static-pages/scripts/menu-creator.js') }}"></script>
</body>
</html>
