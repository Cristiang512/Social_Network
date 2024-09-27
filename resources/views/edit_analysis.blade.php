@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
    <h1>Editar Análisis</h1>

    <form action="{{ route('analysis.update', $analysis) }}" method="POST">
        @csrf
        @method('PUT'){{$analysis}}
        <!-- Aquí coloca los campos de edición del usuario -->
        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" value="{{ $analysis->municipio }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="productor">Nombre del Productor:</label>
            <input type="text" name="productor" id="productor" value="{{ $analysis->productor }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="ciclo">Cliclo:</label>
            <input type="text" name="ciclo" id="ciclo" value="{{ $analysis->ciclo }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="adjunto">Link del Archivo:</label>
            <input type="text" name="adjunto" id="adjunto" value="{{ $analysis->adjunto }}" class="form-control">
        </div>
        <!-- Agrega más campos de edición según tus necesidades -->

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
