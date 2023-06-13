@extends('adminlte::page')

@section('title', 'Beneficiarios')

@section('content_header')
<a href="#" class="btn btn-success">Crear Beneficiario</a>
@stop

@section('content')
<div class="bg-white">
<div clas="table-responsive">
    <table class="table table-bordered" id=table_ana>
        <thead>
        <tr>
            <th>Municipio</th>
            <th>Predio</th>
            <th>Ciclo</th>
            <th>Adjunto</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>AQUITANIA</td>
            <td>Finca el descanso</td>
            <td>Primero</td>
            <td><a href="#" class="btn btn-success"><i class="fas fa-eye"></i></a></td>
            <td><a href="#" class="btn btn-success"><i class="fas fa-pen"></i></a></td>
        </tr>
        <tr>
            <td>GARAGOA</td>
            <td>Finca la justicia</td>
            <td>Primero</td>
            <td><a href="#" class="btn btn-success"><i class="fas fa-eye"></i></a></td>
            <td><a href="#" class="btn btn-success"><i class="fas fa-pen"></i></a></td>
        </tr>
        </tbody>
    </table>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
        $("#table_ana").DataTable();
    </script>
@stop