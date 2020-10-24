<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#004c35">
    <meta name="msapplication-TileColor" content="#ebf2f0">
    <meta name="theme-color" content="#ebf2f0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>curio.codes</title>

    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="form">
            <h1><img src="{{ asset('img/Curio-software-developers-klein.png') }}" alt="Curio Software developers"></h1>

            @yield('content')
            
        </div>
        <div class="aside" style="background-image: url({{ url('/')  }}/img/backgrounds/bg<?php echo rand(1,16) ?>.jpg)"></div>
    </div>
    
</body>
</html>