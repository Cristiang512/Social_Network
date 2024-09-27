@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('content')
    <div class="container">
        <h1>Listado de Grupos</h1>

        @if ($group->isEmpty())
            <div class="alert alert-info">
                <p>No hay Grupos disponibles.</p>
            </div>
        @else
            @foreach ($group as $groupItem)
                <div class="card mt-4">
                    <div class="card-header bg-transparent border-success">
                        <strong>Solicitudes Pendientes para el Grupo: {{ $groupItem->name }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('files/' . $groupItem->icon) }}" class="mr-2" style="width: 40px;">
                            @if ($groupItem->requests->count() > 0)
                                <ul class="list-group">
                                    @foreach ($groupItem->requests as $request)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Solicitud de: {{ $request->user->name }}
                                            <div>
                                                <form action="{{ route('group.acceptRequest', ['groupId' => $groupItem->id_group, 'requestId' => $request->id_group_requests]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                                </form>
                                                <form action="{{ route('group.rejectRequest', ['groupId' => $groupItem->id_group, 'requestId' => $request->id_group_requests]) }}" method="POST" class="d-inline ml-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay solicitudes pendientes para este grupo.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-success"></div>
                </div>
            @endforeach
        @endif
        <div class="mt-4">
            <a href="{{ route('group.index') }}" class="btn btn-primary">Volver al Listado de Grupos</a>
        </div>
    </div>
@endsection
