@extends('layouts.app')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Panel de control</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/panel/concejalias') }}">Consejal&iacute;as </a></li>
        <li class="breadcrumb-item active">Agregar/Editar</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Agregar/Editar Concejal&iacute;as</div>
        <div class="card-block">
            {!! $form !!}
        </div>
        <div class="card-footer">
            <a href="{{ url('/panel/concejalias') }}">Volver</a>
        </div>
    </div>
@endsection