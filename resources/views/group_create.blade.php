@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
<br>
<div class="container">
    <form method="POST" action="{{ route('guardargrupo') }}" enctype="multipart/form-data">
        @csrf
        <div class="card border-success">
            <div class="card-header bg-transparent border-success">Crear grupo de investigacion</div>
            <div class="card-body text-success">
                <div class="form-group">
                    <label for="name">Nombre Grupo</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" required>
                </div>                
                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <textarea class="form-control" id="description" name="description"rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="icon">Icono del Grupo</label>
                    <input type="file" class="form-control-file" id="icon" name="icon" accept="image/*" required>
                </div>
            </div>
            <div class="card-footer bg-transparent border-success">
                <!-- <a href="{{ url('/group') }}" class="btn btn-danger">Cancelar</a>
                <a href="#" class="btn btn-success">Crear</a> -->
                <button type="submit" class="btn btn-success">Crear</button>
                <a href="{{ url('/group') }}" class="btn btn-danger">Cancelar</a>
                <!-- <button type="button" class="btn btn-success">Cancelar</button> -->
            </div>
        </div>
    </form>
</div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop