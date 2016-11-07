@extends('layouts.app')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Panel de control</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/panel/tipos-actividad') }}">Tipos de Actividad </a></li>
        <li class="breadcrumb-item active">Agregar/Editar</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Agregar/Editar Tipos de Actividad</div>
        <div class="card-block">
            {!! $form !!}
        </div>
        <div class="card-footer">
            <a href="{{ url('/panel/tipos-actividad') }}">Volver</a>
        </div>
    </div>
@endsection