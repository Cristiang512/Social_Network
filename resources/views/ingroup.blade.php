@extends('adminlte::page')

@section('title', 'Muro')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div>
    <div class="callout callout-success bg-light text-dark border border-success">
        <div class="callout-header">
            <h5><i class="fas fa-user"></i> Creador: {{$group[0]->name}}</h5>
        </div>
        <div class="callout-body">
            <strong>{{$group[0]->namegroup}}</strong>
        </div>
        <div class="callout-footer">
            <footer class="blockquote-footer">{{$group[0]->description}}</footer>
        </div>
    </div>
    
    @if (auth()->check())
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <form method="POST" action="{{ route('guardaridea') }}" enctype="multipart/form-data">
            @csrf
            <div class="card border-success">
                <div class="card-header text-success">Comparte tus ideas</div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" id="text" name="text" placeholder="Digita lo que deseas publicar" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imageField">Subir imagen</label>
                        <input type="file" class="form-control-file" name="imageField" accept="image/*" id="imageField" onchange="toggleVideoLinkField()">
                    </div>
                    <div class="form-group">
                        <label for="video_link">Enlace de video</label>
                        <input type="text" class="form-control @error('video_link') is-invalid @enderror" name="video_link" placeholder="Enlace de video" id="videoLinkField" onchange="toggleImageField()">
                        @error('video_link')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer bg-transparent border-success text-right">
                    <input type="hidden" name="id_group" value="{{ $group[0]->id_group }}">
                    <button type="submit" class="btn btn-success">Publicar</button>
                </div>
            </div>
        </form>

    @else
        <!-- Mostrar algo si el usuario no está autenticado -->
        <p>Debes iniciar sesión para poder publicar.</p>
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
    @if (count($idea) > 0)
        @foreach ($idea as $item)
            <div class="card">
                <div class="card-header">
                    <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 40px;"/>
                    {{ $item->name }}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $item->text }}</p>
                        <footer class="blockquote-footer">BoyacaASCTI <i class="{{ $iconos[array_rand($iconos)] }}"></i></footer>
                    </blockquote>
                    <!-- Mostrar imagen si imageField está cargado -->
                    @if ($item->imageField)
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('files/' . $item->imageField) }}" alt="Imagen" style="max-width: 500px; max-height: 400px; object-fit: contain;">
                        </div>
                    @endif

                    <!-- Mostrar video de YouTube si video_link está cargado -->
                    @if ($item->video_link)
                        <div class="d-flex justify-content-center">
                            <iframe width="620" height="540" src="https://www.youtube.com/embed/{{ $item->video_link }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="text-left">
                        Publicado el {{ $item->date }}
                    </div>
                    <div class="text-right">
                        @if ($item->id_user === auth()->user()->id || auth()->user()->rol === 1) <!-- Verifica si el usuario actual es el autor de la publicación -->
                            <form action="{{ route('eliminar-idea', $item->id_idea) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="card-link btn-link" onclick="return confirm('¿Estás seguro de que deseas eliminar esta idea?')">
                                    <i class="fas fa-trash"></i> Eliminar Idea
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('like.idea', $item->id_idea) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="card-link btn-link">
                                <i class="fas fa-thumbs-up"></i> Me gusta <span class="badge badge-primary">{{ $item->likes_count }}</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="comentarios-container" style="display: none;"> <!-- Inicia oculto por defecto -->
                        @if ($item->comentarios)
                            <ul class="comentarios-list" style="list-style: none; padding: 0;">
                                @php
                                    $idComments = explode(',', $item->idcomments);
                                    $comentarios = explode(',', $item->comentarios);
                                    $commentUsers = explode(',', $item->comment_users);
                                @endphp
                                @foreach ($comentarios as $index => $comentario)
                                    <li>
                                        @if(isset($commentUsers[$index]) && isset($comentario[$index]))
                                            <strong>{{ $commentUsers[$index] }}:</strong> {{ $comentario[$index] }}
                                        @endif
                                        @if (isset($commentUsers[$index]) && isset($idComments[$index]))
                                            @if ($commentUsers[$index] === auth()->user()->name) <!-- Comprueba si el usuario actual es el autor del comentario -->
                                                <span class="comentario-options">
                                                    <button class="btn btn-link btn-delete-comentario" data-index="{{ $index }}" data-comentario-id="{{$idComments[$index] }}">Eliminar</button>
                                                </span>
                                            @endif
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
                <div class="card-footer comentarios-form" style="display: none;">
                    <form action="{{ route('comentarios.group.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_idea" id="id_idea" value="{{ $item->id_idea }}">
                        <div class="input-group mt-3">
                            <input type="text" class="form-control" name="comentario" id="comentario" placeholder="Agregar comentario">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Comentar</button>
                            </div>
                        </div>
                    </form>
                </div>
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

    function toggleImageField() {
        var videoLinkField = document.getElementById('videoLinkField');
        var imageField = document.getElementById('imageField');
        
        if (videoLinkField.value !== '') {
            imageField.disabled = true;
        } else {
            imageField.disabled = false;
        }
    }
    
    function toggleVideoLinkField() {
        var videoLinkField = document.getElementById('videoLinkField');
        var imageField = document.getElementById('imageField');
        
        if (imageField.value !== '') {
            videoLinkField.disabled = true;
        } else {
            videoLinkField.disabled = false;
        }
    }

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