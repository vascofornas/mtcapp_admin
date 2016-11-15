<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de administraci&oacute;n de aplicaci&oacute;n">
    <meta name="author" content="Donato Laynes">
    <link rel="shortcut icon" href="{{ asset('themes/coreui-static/img/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icons -->
    <link href="{{ asset('themes/coreui-static/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/coreui-static/css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ asset('themes/coreui-static/css/style.css') }}" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <link rel="stylesheet" href="{{ asset('css/admin.css')}}" />
    @yield('head')
</head>
<body class="navbar-fixed sidebar-nav fixed-nav">
    <header class="navbar">
        <div class="container-fluid">
            <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">☰</button>
            <a class="navbar-brand" href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}">Control</a>
            <ul class="nav navbar-nav hidden-md-down">
                <li class="nav-item">
                    <a class="nav-link navbar-toggler layout-toggler" href="#">☰</a>
                </li>
            </ul>
            <ul class="nav navbar-nav float-xs-right hidden-md-down">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Ingresar</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link"
                           data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="hidden-md-down">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Cerrar sesi&oacute;n</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </header>
    @include('partials.sidebar')

    <!-- Main content -->
    <main class="main">
        @yield('breadcrumb')
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container-fluid -->
    </main>

    <footer class="footer">
        <span class="text-left">
            <a href="http://google.com">Muevete por 3 cantos</a> © 2016.
        </span>
        <span class="float-xs-right">
            Versi&oacute;n 0.1a
        </span>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('themes/coreui-static/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('themes/coreui-static/bower_components/tether/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('themes/coreui-static/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('themes/coreui-static/js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>
</html>
