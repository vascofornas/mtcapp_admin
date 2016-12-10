@extends('layouts.app')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Panel de control</a></li>
        <li class="breadcrumb-item active">Vales</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Listado de Vales de descuento</div>
        <div class="card-block">
            {!! $grid !!}
        </div>
    </div>
@endsection