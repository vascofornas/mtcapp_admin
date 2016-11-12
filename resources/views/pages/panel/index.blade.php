@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Panel de control</a></li>
        
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Bienvenido al administrador de la aplicación Tres Cantos</div>
        <div class="card-block">
            Seleccione una de las opciones del menú lateral
        </div>
    </div>
@endsection