<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="/apple-touch-icon.png">
    <link rel="icon"
          type="image/png"
          sizes="32x32"
          href="/favicon-32x32.png">
    <link rel="icon"
          type="image/png"
          sizes="16x16"
          href="/favicon-16x16.png">
    <link rel="manifest"
          href="/site.webmanifest">
    <link rel="mask-icon"
          href="/safari-pinned-tab.svg"
          color="#004c35">
    <meta name="msapplication-TileColor"
          content="#ebf2f0">
    <meta name="theme-color"
          content="#ebf2f0">

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>curio.codes</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
          crossorigin="anonymous">

    @vite(['resources/css/shared.css', 'resources/css/login.css'])

    @stack('styles')
</head>

<body class="cover-background" style="background-image: url({{ $backgrounds[array_rand($backgrounds)] }})">
    <div class="container login full-height">
        <div class="form glassy left-edge">
            <h1><img src="{{ Vite::asset('resources/img/curio-sd-logo.png') }}"
                     alt="Curio Software developers"></h1>

            @yield('content')
        </div>
    </div>
</body>

</html>
