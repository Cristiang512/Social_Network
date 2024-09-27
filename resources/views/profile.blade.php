@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <!-- <h1>Perfil Usuario</h1> -->
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de Perfil</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('files/' . $user->foto) }}" class="img-circle" style="max-width: 200px;" alt="Foto de perfil">
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="foto">Cambiar foto de perfil:</label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="form-control-file">
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
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edad">Edad:</label>
                            <input type="number" name="edad" id="edad" value="{{ $user->edad }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="profesion">Profesión:</label>
                            <input type="text" name="profesion" id="profesion" value="{{ $user->profesion }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="municipio">Municipio:</label>
                            <input type="text" name="municipio" id="municipio" value="{{ $user->municipio }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="vereda">Vereda:</label>
                            <input type="text" name="vereda" id="vereda" value="{{ $user->vereda }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono:</label>
                            <input type="number" name="telefono" id="telefono" value="{{ $user->telefono }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" value="{{ $user->direccion }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="predio">Predio:</label>
                            <input type="text" name="predio" id="predio" value="{{ $user->predio }}" class="form-control">
                        </div>
                        <!-- Agrega más campos de perfil según tus necesidades -->

                        <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
