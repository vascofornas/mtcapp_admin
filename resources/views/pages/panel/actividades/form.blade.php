@extends('layouts.app')

@section('head')
    {!! Rapyd::styles() !!}
    <link rel="stylesheet" href="{{ asset('packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css') }}" />
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Panel de control</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/panel/actividades') }}">Actividades </a></li>
        <li class="breadcrumb-item active">Agregar/Editar</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Agregar/Editar Actividades</div>
        <div class="card-block">
            {!! $form !!}
        </div>
        <div class="card-footer">
            <a href="{{ url('/panel/actividades') }}">Volver</a>
        </div>
    </div>
@endsection

@section('scripts')
    {!! Rapyd::scripts() !!}
@endsection