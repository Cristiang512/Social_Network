@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
    <h1>Crear Usuario</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <!-- Aquí coloca los campos de creación del usuario -->
        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="vereda">Vereda:</label>
            <input type="text" name="vereda" id="vereda" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="documento">Documento:</label>
            <input type="number" name="documento" id="documento" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono" id="telefono" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="predio">Predio:</label>
            <input type="text" name="predio" id="predio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <!-- Agrega más campos de creación según tus necesidades -->

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
