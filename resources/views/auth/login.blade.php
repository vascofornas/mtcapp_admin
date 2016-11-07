@extends('layouts.default')

@section('head')
<style>
.recordar { line-height: 100%; padding-left: 10px; padding-top: 10px; }
    .default-layout { background: url("/img/background-logon-screen-windows-web-desktop-wallpaper-abstract.jpg") center center }
</style>
@endsection

@section('content')
    <div class="card mx-2">
        <div class="card-block p-2">
            <h1>Ingreso al sistema</h1>
            <p class="text-muted">Por favor llene sus datos personales</p>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                <div class="input-group mb-1{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <span class="input-group-addon">@</span>
                    <input  id="email" name="email"
                            type="email" class="form-control" placeholder="Correo electr&oacute;nico"
                            value="{{ old('email') }}" required autofocus />
                    @if ($errors->has('email'))
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="input-group mb-1{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                    <input  id="password" name="password"
                            type="password" class="form-control" placeholder="Contrase&ntilde;a">
                    @if ($errors->has('password'))
                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="input-group mb-2">
                    <span class="input-group-addon">
                        <input id="remember" type="checkbox" name="remember">
                    </span>
                    <label for="remember" class="recordar">Mantener sesi&oacute;n iniciada?</label>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary px-2">Enviar</button>
                    </div>
                    <!--
                    <div class="col-xs-6 text-xs-right">
                        <button type="button" class="btn btn-link px-0">Forgot password?</button>
                    </div>-->
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/themes/coreui-static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/themes/coreui-static/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="/themes/coreui-static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
@endsection