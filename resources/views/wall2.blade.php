@extends('adminlte::page')

@section('title', 'Muro')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div>
    @if (auth()->check())

        <form method="POST" action="{{ route('guardarpublicaciones') }}" enctype="multipart/form-data">
            @csrf
            <div class="card border-success">
                <div class="card-header bg-success text-white">Comparte tus experiencias</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="publication">Contenido</label>
                        <textarea class="form-control" id="publication" name="publication" placeholder="Digita lo que deseas publicar" rows="3" required></textarea>
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
                <div class="card-footer bg-transparent border-success">
                    <button type="submit" class="btn btn-success">Publicar</button>
                </div>
            </div>
        </form>
    @else
        <!-- Mostrar algo si el usuario no está autenticado -->
        <p>Debes <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a> para poder publicar.</p>
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
    
    @if (count($publications) > 0)
        @foreach ($publications as $publication)
            <div class="card">
                <div class="card-header">
                    <img src="{!! asset('vendor\adminlte\dist\img\logo_boyaca.png') !!}" class="imagen-circle" style="width: 40px;"/>
                    {{ $publication->name }}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $publication->text }}</p>
                        <footer class="blockquote-footer">BoyacaASCTI <i class="{{ $iconos[array_rand($iconos)] }}"></i></footer>
                    </blockquote>

                    <!-- Mostrar imagen si imageField está cargado -->
                    @if ($publication->imageField)
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('files/' . $publication->imageField) }}" alt="Imagen" width="700" height="500">
                        </div>
                    @endif

                    <!-- Mostrar video de YouTube si video_link está cargado -->
                    @if ($publication->video_link)
                        <div class="d-flex justify-content-center">
                            <iframe width="620" height="540" src="https://www.youtube.com/embed/{{ $publication->video_link }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="text-left">
                        Publicado el {{ $publication->date }}
                    </div>
                    <div class="text-right">
                        <form action="{{ route('like.toggle', $publication->id_publication) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="card-link btn-link">
                                <i class="fas fa-thumbs-up"></i> Me gusta <span class="badge badge-primary">{{ $publication->likes_count }}</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <h5>Comentarios:</h5>
                    <div class="comentarios-container" style="display: none;"> <!-- Inicia oculto por defecto -->
                        @if ($publication->comentarios)
                            <ul class="comentarios-list" style="list-style: none; padding: 0;">
                                @php
                                    $comentarios = explode(',', $publication->comentarios);
                                    $commentUsers = explode(',', $publication->comment_users);
                                @endphp
                                @foreach ($comentarios as $index => $comentario)
                                    <li><strong>{{ $commentUsers[$index] }}:</strong> {{ $comentario }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay comentarios.</p>
                        @endif
                    </div>
                    <button class="btn btn-link btn-toggle-comentarios">Mostrar/Ocultar Comentarios</button>
                </div>
                <div class="card-footer comentarios-form" style="display: none;">
                    <form action="{{ route('comentarios.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_publication" id="id_publication" value="{{ $publication->id_publication }}">
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
<style>
    .comentarios-container {
        margin-bottom: 10px;
    }
    .comentarios-form {
        margin-top: 10px;
    }
</style>
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
    });
</script>
@stop