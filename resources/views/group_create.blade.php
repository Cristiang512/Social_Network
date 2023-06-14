@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
<br>
<div class="container">
    <form>
        <div class="card border-success">
            <div class="card-header bg-transparent border-success">Crear grupo de investigacion</div>
            <div class="card-body text-success">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre Grupo</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripcion</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Icono del Grupo</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
            </div>
            <div class="card-footer bg-transparent border-success">
                <a href="{{ url('/group') }}" class="btn btn-danger">Cancelar</a>
                <a href="#" class="btn btn-success">Crear</a>
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