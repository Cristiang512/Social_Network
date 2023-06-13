@extends('adminlte::page')

@section('title', 'Muro')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div>
    <!-- ZONA PARA HACER PUBLICACIONES -->
    <div class="card border-success">
        <div class="card-header text-success">Comparte tus experiencias</div>
        <div class="card-body ">
                <textarea class="form-control" id="" placeholder="Digita lo que deseas publicar" rows="3"></textarea>
        </div>
        <div class="card-footer bg-transparent border-success">
            <a href="" class="btn btn-success">Publicar</a>
        </div>
    </div>

    <!-- ZONA PARA VER LAS ULTIMAS PUBLICACIONES -->

    @for ($i = 1; $i <=10; $i++)
    <div class="card">
        <div class="card-header">
            <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 40px;"/>
            Usuario Publicador
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
            </blockquote>
        </div>
        <div class="card-footer">
            <div class="text-left">
                {{$i}} days ago
            </div>
            <div class="text-right">
                <a href="#!" class="card-link">Me gusta</a>
                <a href="#!" class="card-link">Comentarios</a>
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