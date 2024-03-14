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

    @vite(['resources/css/login.css'])

    @stack('styles')
</head>

<body>
    <div class="container">
        <div class="form">
            <h1><img src="{{ Vite::asset('resources/img/Curio-software-developers-klein.png') }}"
                     alt="Curio Software developers"></h1>

            @yield('content')
        </div>

        @php
            // Vite must get all asset paths, or it wont properly build the assets (so no looping here)
            $backgrounds = [
                Vite::asset('resources/img/backgrounds/bg1.jpg'),
                Vite::asset('resources/img/backgrounds/bg2.jpg'),
                Vite::asset('resources/img/backgrounds/bg3.jpg'),
                Vite::asset('resources/img/backgrounds/bg4.jpg'),
                Vite::asset('resources/img/backgrounds/bg5.jpg'),
                Vite::asset('resources/img/backgrounds/bg6.jpg'),
                Vite::asset('resources/img/backgrounds/bg7.jpg'),
                Vite::asset('resources/img/backgrounds/bg8.jpg'),
                Vite::asset('resources/img/backgrounds/bg9.jpg'),
                Vite::asset('resources/img/backgrounds/bg10.jpg'),
                Vite::asset('resources/img/backgrounds/bg11.jpg'),
                Vite::asset('resources/img/backgrounds/bg12.jpg'),
                Vite::asset('resources/img/backgrounds/bg13.jpg'),
                Vite::asset('resources/img/backgrounds/bg14.jpg'),
                Vite::asset('resources/img/backgrounds/bg15.jpg'),
                Vite::asset('resources/img/backgrounds/bg16.jpg'),
            ];
        @endphp
        <div class="aside"
                style="background-image: url({{ $backgrounds[array_rand($backgrounds)] }})"></div>
    </div>
</body>

</html>
