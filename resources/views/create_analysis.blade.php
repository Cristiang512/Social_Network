@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
    <h1>Crear Análisis</h1>

    <form action="{{ route('analysis.store') }}" method="POST">
        @csrf
        <!-- Aquí coloca los campos de creación del usuario -->
        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="productor">Nombre del Productor:</label>
            <input type="text" name="productor" id="productor" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ciclo">Ciclo:</label>
            <input type="text" name="ciclo" id="ciclo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="adjunto">Link del Archivo:</label>
            <input type="text" name="adjunto" id="adjunto" class="form-control" required>
        </div>
        <!-- Agrega más campos de creación según tus necesidades -->

        <button type="submit" class="btn btn-primary">Crear Análisis</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
