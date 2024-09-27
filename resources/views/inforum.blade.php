@extends('adminlte::page')

@section('title', 'Muro')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div>
    <div class="callout callout-success bg-light text-dark border border-success">
        <div class="callout-header">
            <h5><i class="fas fa-user"></i> Creador: {{$forums[0]->name}}</h5>
        </div>
        <div class="callout-body">
            <strong>Descripción del Foro.</strong>
        </div>
        <div class="callout-footer">
            <footer class="blockquote-footer">{{$forums[0]->description}}</footer>
            @if (now() <= $forums[0]->closing_date)
                <p class="text-success">Fecha de cierre: {{$forums[0]->closing_date}}</p>
            @else
                <p class="text-danger">El foro se cerró el {{$forums[0]->closing_date}}</p>
            @endif
        </div>
    </div>


    
    @if (now() <= $forums[0]->closing_date)
        <form method="POST" action="{{ route('guardaridea.forum') }}">
            @csrf
            <div class="card border-success">
                <div class="card-header text-success">Comparte tus experiencia</div>
                <div class="card-body">
                    <textarea class="form-control" id="text" name="text" placeholder="Digita lo que deseas publicar" rows="3"></textarea>
                </div>
                <input type="hidden" name="id_forum" value="{{ $forums[0]->id_forum }}">
                <div class="card-footer bg-transparent border-success">
                    <button type="submit" class="btn btn-success">Publicar</button>
                </div>
            </div>
        </form>
    @endif

    <!-- ZONA PARA VER LAS ULTIMAS PUBLICACIONES -->
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

    @if (count($ideaForum) > 0)
        @foreach ($ideaForum as $idea)
            <div class="card">
                <div class="card-header">
                    <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 40px;"/>
                    {{ $idea->name }}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $idea->text }}</p>
                        <footer class="blockquote-footer">BoyacaASCTI <i class="{{ $iconos[array_rand($iconos)] }}"></i></footer>
                    </blockquote>
                </div>
                <div class="card-footer">
                    <div class="text-left">
                        Publicado el {{ $idea->date }}
                    </div>
                </div>
                <div class="text-right">
                        @if ($idea->id_user === auth()->user()->id || auth()->user()->rol === 1) <!-- Verifica si el usuario actual es el autor de la publicación -->
                            <form action="{{ route('eliminar-idea-forum', $idea->id_idea_forum) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="card-link btn-link" onclick="return confirm('¿Estás seguro de que deseas eliminar esta experiencia?')">
                                    <i class="fas fa-trash"></i> Eliminar Experiencia
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('like.idea.forum', $idea->id_idea_forum) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="card-link btn-link">
                                <i class="fas fa-thumbs-up"></i> Me gusta <span class="badge badge-primary">{{ $idea->likes_count }}</span>
                            </button>
                        </form>
                    </div>
                <div class="card-footer">
                    <div class="comentarios-container" style="display: none;"> <!-- Inicia oculto por defecto -->
                        @if ($idea->comentarios)
                            <ul class="comentarios-list" style="list-style: none; padding: 0;">
                                @php
                                    $idComments = explode(',', $idea->idcomments);
                                    $comentarios = explode(',', $idea->comentarios);
                                    $commentUsers = explode(',', $idea->comment_users);
                                @endphp
                                @foreach ($comentarios as $index => $comentario)
                                    <li>
                                        <strong>{{ $commentUsers[$index] }}:</strong> {{$comentario}}
                                        @if ($commentUsers[$index] === auth()->user()->name) <!-- Comprueba si el usuario actual es el autor del comentario -->
                                            <span class="comentario-options">
                                                <!-- <button class="btn btn-link btn-edit-comentario" data-index="{{ $index }}" data-comentario-id="{{$idComments[$index]}}">Editar</button> -->
                                                <button class="btn btn-link btn-delete-comentario" data-index="{{ $index }}" data-comentario-id="{{$idComments[$index] }}">Eliminar</button>
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay comentarios.</p>
                        @endif
                    </div>
                    <button class="btn btn-link btn-toggle-comentarios">Mostrar/Ocultar Comentarios</button>
                </div>
                @if (now() <= $forums[0]->closing_date)
                    <div class="card-footer comentarios-form" style="display: none;">
                        <form action="{{ route('comentarios.forum.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_idea_forum" id="id_idea_forum" value="{{ $idea->id_idea_forum }}">
                            <div class="input-group mt-3">
                                <input type="text" class="form-control" name="comentario" id="comentario" placeholder="Agregar comentario">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Comentar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif  
            </div>
        @endforeach
    @else
        <p>No hay publicaciones disponibles.</p>
    @endif

    
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>

    document.addEventListener("DOMContentLoaded", function() {
        const btnToggleComentarios = document.querySelectorAll(".btn-toggle-comentarios");
        btnToggleComentarios.forEach(btn => {
            btn.addEventListener("click", () => {
                const comentariosContainer = btn.parentElement.querySelector(".comentarios-container");
                comentariosContainer.style.display = comentariosContainer.style.display === "none" ? "block" : "none";
                const comentariosForm = btn.parentElement.nextElementSibling;
                comentariosForm.style.display = comentariosForm.style.display === "none" ? "block" : "none";
            });
        });
        const btnDeleteComentarios = document.querySelectorAll(".btn-delete-comentario");

        btnDeleteComentarios.forEach(btn => {
            btn.addEventListener("click", () => {
                const comentarioId = btn.getAttribute("data-comentario-id");

                if (confirm("¿Estás seguro de que deseas eliminar este comentario?")) {
                    // Envía una solicitud AJAX para eliminar el comentario
                    fetch(`/comentarios/${comentarioId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Asegúrate de pasar el token CSRF correcto
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Elimina el comentario de la interfaz de usuario usando el atributo data-comentario-id
                        const comentarioElement = document.querySelector(`[data-comentario-id="${comentarioId}"]`);
                        if (comentarioElement) {
                            comentarioElement.closest("li").remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar el comentario:', error);
                    });
                }
            });
        });
    });    
</script>
@stop