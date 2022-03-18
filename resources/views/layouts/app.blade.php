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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <script src="https://use.fontawesome.com/30b7c2b05b.js"></script>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-brand-light">
        <div class="container mt-0 flex-column flex-md-row">
            <a class="navbar-brand color-brand mr-0" href="{{ url('me') }}">curio.codes</a>
            @auth
                <div class="justify-content-end">
                    <ul class="navbar-nav flex-column flex-md-row align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="/me">Dashboard</a>
                        </li>
                        @if(Auth::user()->type == 'teacher')
                            <li class="nav-item">
                                <a class="nav-link" href="/links">Links</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/clients">Apps</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/groups">Groepen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/users">Gebruikers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/grouplogin">Groepsaccounts</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/users/{{ Auth::user()->id }}/profile">Profiel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout"><i class="fa fa-fw fa-sign-out"></i></a>
                        </li>
                    </ul>
                </div>
            @endauth
    </div>
    </nav>

    <div class="main">
            @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    @stack('scripts')
</body>
</html>
