@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
<div class="row">
    @if(Session::has('mensaje'))
        <div class="alert alert-success">
            <p class="mb-0">Información:</p>
            <ul class="mb-0">
                {{ Session::get('mensaje') }}
            </ul>
        </div>
    @endif
    <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="{{ url('/group/create') }}" class="btn btn-success">Crear Grupo</a>
    </div>

    <!-- @if (count($group) > 0)
        @for ($i = 0; $i < count($group); $i++)
            <div class="mt-2 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="card border-success">
                <div class="card-header bg-transparent border-success"><strong>Grupo:</strong> {{$group[$i]->namegroup}}</div>
                <div class="card-body text-success text-center">
                    <img src="{{ asset('files/' . $group[$i]->icon) }}" class="imagen-circle" style="width: 80%;"/>
                </div>
                <div class="card-footer bg-transparent border-success text-right">
                <a href="{{ url('/group/'. $group[$i]->id_group.'/index') }}" class="btn btn-success">Explorar</a>
                </div>
                </div>
            </div>
        @endfor
    @else
        <p>No hay Grupos disponibles.</p>
    @endif -->

    @if (count($group) > 0)
    @foreach ($group as $groupItem)
    <div class="mt-2 col-lg-3 col-md-3 col-sm-4 col-xs-12">
        <div class="card border-success">
            <div class="card-header bg-transparent border-success"><strong>Grupo:</strong> {{ $groupItem->namegroup }}</div>
            <div class="card-body text-success text-center">
                <img src="{{ asset('files/' . $groupItem->icon) }}" class="imagen-circle" style="width: 80%;" />
            </div>
            <div class="card-footer bg-transparent border-success text-right">
                @if (Auth::check())
                    @if ($groupItem->isMember(Auth::user()))
                        <a href="{{ url('/group/' . $groupItem->id_group . '/index') }}" class="btn btn-success">Explorar</a>
                    @elseif ($groupItem->hasPendingRequest(Auth::user()))
                        <span class="text-info">Pendiente de aprobación</span>
                    @else
                        <form method="POST" action="{{ route('send.request', ['group_id' => $groupItem->id_group]) }}">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ $groupItem->id_group }}">
                            <button type="submit" class="btn btn-primary">Solicitar unirse</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
    <p>No hay Grupos disponibles.</p>
@endif

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop