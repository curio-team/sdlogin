
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AMO login</title>

    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="form">
            <h1><img src="{{ asset('img/amologin.png') }}" alt="AMO login"></h1>

            @yield('content')
            
            <footer>
                <p>Radius College | Applicatie- en mediaontwikkeling</p>
            </footer>
        </div>
        <div class="aside" style="background-image: url({{ url('/')  }}/img/backgrounds/bg<?php echo rand(1,16) ?>.jpg)"></div>
    </div>
    
</body>
</html>