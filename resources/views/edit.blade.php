@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
    <h1>Editar Usuario</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Aquí coloca los campos de edición del usuario -->
        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" value="{{ $user->municipio }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="vereda">Vereda:</label>
            <input type="text" name="vereda" id="vereda" value="{{ $user->vereda }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="documento">Documento:</label>
            <input type="number" name="documento" id="documento" value="{{ $user->documento }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="telefono">Telefono:</label>
            <input type="number" name="telefono" id="telefono" value="{{ $user->telefono }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="predio">Predio:</label>
            <input type="text" name="predio" id="predio" value="{{ $user->predio }}" class="form-control">
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
