@extends('adminlte::page')

@section('title', 'Beneficiarios')

@section('content_header')
<a href="{{ route('users.create') }}" class="btn btn-success">Crear Beneficiario</a>
@stop

@section('content')
<div class="bg-white">
<div clas="table-responsive">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <table class="table table-bordered" id=table_ana>
        <thead>
        <tr>
            <th>#</th>
            <th>Municipio</th>
            <th>Nombre del Productor</th>
            <th>No. Cédula</th>
            <th>No. Teléfono</th>
            <th style="text-align: center;">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->municipio }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->documento }}</td>
                <td>{{ $user->telefono }}</td>
                <td>
                    @if (auth()->check() && auth()->user()->rol === 1)
                        <div class="d-flex">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-success btn-sm mr-2" data-toggle="tooltip" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if ($user->rol !== 1 )
                                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="rol" value="1">
                                    <button type="submit" class="btn btn-link btn-sm text-success" data-toggle="tooltip" title="Cambiar a Administrador">
                                        <span class="fas fa-user-check"></span>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="rol" value="2">
                                    <button type="submit" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Quitar Administrador">
                                        <span class="fas fa-user-times"></span>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('reset.password', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link btn-sm text-info" data-toggle="tooltip" title="Restablecer Contraseña">
                                    <span class="fas fa-lock"></span>
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-muted">No tienes permisos</span>
                    @endif
                </td>

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