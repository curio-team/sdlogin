<!DOCTYPE html>
<html lang="en">
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

        @vite(['resources/css/shared.css', 'resources/css/login.css'])

        <style>
            .center{
                display: grid;
                place-content: center;
                z-index: 1;
            }

            .center > div {
                max-width: 960px;
                padding: 2em 5em;
            }

            .inset {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }

            .stack {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 1em;
            }

            .text-center {
                text-align: center;
            }

            .message {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: .5em;
                font-size: 1.5em;
                margin-top: 1em;
            }
        </style>

        @stack('styles')

        @include('partials.quick-styles')
    </head>

    <body>
        <div class="container center cover-background" style="background-image: url({{ $backgrounds[array_rand($backgrounds)] }})">
            <div class="stack glassy full-edge">
                <h1 class="text-center"><img src="{{ Vite::asset('resources/img/curio-sd-logo.png') }}"
                            alt="Curio Software developers"></h1>

                <div class="message">
                    <h2 class="text-center">@yield('title')</h2>

                    @yield('message')
                </div>

                <div class="stack mt">
                    <a class="button button-big" href="{{ url()->previous() }}">Terug naar de vorige pagina</a>
                    <a class="button" href="{{ route('home') }}">Naar de homepagina</a>
                </div>
            </div>
        </div>
    </body>
</html>
