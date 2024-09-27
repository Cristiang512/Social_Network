@extends('adminlte::page')

@section('title', 'Foros')

@section('content_header')
    <a href="{{ url('/forum/create') }}" class="btn btn-success">Crear Foro</a>
@stop

@section('content')
<div>
    <?php
        $iconos = [
            'fa fa-star',
            'fa fa-heart',
            'fa fa-thumbs-up',
            'fa fa-smile',
            'fa fa-music',
            'fa fa-globe',
            'fa fa-camera',
            'fa fa-envelope',
            'fa fa-cloud',
            'fa fa-sun',
            'fa fa-moon',
            'fa fa-check',
            'fa fa-times',
            'fa fa-user',
            'fa fa-users',
            'fa fa-cog',
            'fa fa-search',
            'fa fa-home',
            'fa fa-book',
            'fa fa-briefcase',
            'fa fa-heartbeat',
            'fa fa-paw',
            'fa fa-tree',
            'fa fa-umbrella',
            'fa fa-rocket',
            'fa fa-star-o',
            'fa fa-thumbs-o-up',
            'fa fa-smile-o',
            'fa fa-music',
            'fa fa-globe',
            'fa fa-camera',
            'fa fa-envelope-o',
            'fa fa-cloud',
            'fa fa-sun-o',
            'fa fa-moon-o',
        ];
    ?>
    @if (count($forums) > 0)
        @for ($i = 0; $i < count($forums); $i++)
            <div class="card">
                <div class="card-header">
                    <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 40px;"/>
                    {{$forums[$i]->name}}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                    <p>{{$forums[$i]->description}}</p>
                    <footer class="blockquote-footer">BoyacaASCTI <i class="{{ $iconos[array_rand($iconos)] }}"></i></footer>
                    </blockquote>
                </div>
                <div class="card-footer bg-transparent border-success">
                    <a href="{{ url('/forum/' . $forums[$i]->id_forum . '/index') }}" class="btn btn-success">Explorar</a>
                    <!-- <button type="submit" class="btn btn-success">Participar</button> -->
                </div>
                <div class="card-footer">
                    <div class="text-left">
                        Creado el {{$forums[$i]->opening_date}} y se cerrará el {{$forums[$i]->closing_date}}
                    </div>
                </div>
            </div>
        @endfor
    @else
        <p>No hay publicaciones disponibles.</p>
    @endif
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop