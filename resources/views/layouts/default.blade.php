<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de administraci&oacute;n de aplicaci&oacute;n">
    <meta name="author" content="Donato Laynes">
    <link rel="shortcut icon" href="{{ asset('themes/coreui-static//img/favicon.png') }}">
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
    @yield('head')
</head>
<body class="default-layout">
<div class="container d-table">
    <div class="d-100vh-va-middle">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@yield('scripts')
</body>
</html>