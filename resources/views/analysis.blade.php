@extends('adminlte::page')

@section('title', 'Analisis')

@section('content_header')
    <a href="{{ route('analysis.create') }}"class="btn btn-success">Crear Análisis</a>
@stop

@section('content')
<div class="bg-white">
<div clas="table-responsive">
    <table class="table table-bordered" id=table_ana>
        <thead>
        <tr>
            <th>#</th>
            <th>Municipio</th>
            <th>Nombre del Productor</th>
            <th>Ciclo</th>
            <th>Adjunto</th>
            <!-- <th>Acciones</th> -->
        </tr>
        </thead>
        <tbody>
            @foreach ($analysis as $analy)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $analy->municipio }}</td>
                    <td>{{ $analy->productor }}</td>
                    <td>{{ $analy->ciclo }}</td>
                    <td>
                        <a href="{{ $analy->adjunto }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <!-- <td>
                        <a href="{{ route('analysis.edit', ['analysis' => $analy->id_analysis]) }}" class="btn btn-success">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td> -->
                </tr>
            @endforeach
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