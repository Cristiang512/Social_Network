@extends('adminlte::page')

@section('title', 'Foros')

@section('content_header')
    <a href="{{ url('/forum/create') }}" class="btn btn-success">Crear Foro</a>
@stop

@section('content')
<div class="container"> 
    @for ($i = 1; $i <=10; $i++)
        <div class="card mb-2">
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
                    <a href="#!" class="btn btn-success">Participar</a>
                    {{$i}} days ago
                    
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