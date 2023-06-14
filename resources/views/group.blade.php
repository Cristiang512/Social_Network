@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="{{ url('/group/create') }}" class="btn btn-success">Crear Grupo</a>
    </div>

@for ($i = 1; $i <=10; $i++)
    <div class="mt-2 col-lg-3 col-md-3 col-sm-4 col-xs-12">
        <div class="card border-success">
        <div class="card-header bg-transparent border-success">Nombre Grupo {{$i}}</div>
        <div class="card-body text-success text-center">
            <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 80%;"/>
        </div>
        <div class="card-footer bg-transparent border-success text-right">
        <a href="#" class="btn btn-success">Explorar</a>
        </div>
        </div>
    </div>
@endfor
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop