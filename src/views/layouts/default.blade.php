<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Filmoteca')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">

        @include('filmoteca/static-pages::partials.flashes')

        @yield('content')
    </div>
</body>
</html>