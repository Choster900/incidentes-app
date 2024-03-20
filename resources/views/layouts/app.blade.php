<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>

<style>
    body {
            background-image: url('/img/login1.avif');
            background-size: cover;
            background-position: center;
            margin: 0;
            /* Asegúrate de que no haya ningún margen en el cuerpo */
            padding: 0;
            /* Asegúrate de que no haya ningún relleno en el cuerpo */
            height: 100vh;
            /* Establece la altura del cuerpo al 100% del viewport height */
        }
</style>
