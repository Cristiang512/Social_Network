@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')
<br>
<div class="container">
    <form method="POST" action="{{ route('guardarforo') }}" enctype="multipart/form-data">
        @csrf
        <div class="card border-success">
            <div class="card-header bg-transparent border-success">Crear foro</div>
            <div class="card-body text-success">
                               
                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="opening">Fecha apertura:</label>
                    <input type="text" name="opening" id="opening" value="{{ now()->format('Y-m-d') }}" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="closing">Fecha cierre</label>
                    <input type="date" class="form-control" id="closing" name="closing" placeholder=""
                        min="{{ now()->addDay()->toDateString() }}" required>
                </div>
                
            </div>
            <div class="card-footer bg-transparent border-success">
                <a href="{{ url('/group') }}" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Crear</button>
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