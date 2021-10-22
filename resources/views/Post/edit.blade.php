@extends('master')

@section('content')

<div class="cuadro">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar Post') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/edit') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')  

                        <input type="hidden" name="id" value="{{ $post->id }}">

                        <!--para saber si el deleteImagen debe ser required-->
                        @if ($post->imagen)
                            <input type="hidden" name="selectIsRequired" value="true">
                        @else
                            <input type="hidden" name="selectIsRequired" value="false">
                        @endif

                        <div class="form-floating mb-3 mx-5">
                            <input type="text" class="form-control" name="titulo" id="titulo" value="{{ old('titulo') ?? $post->titulo }}" placeholder="Ingrese Título" maxlength="150" required>
                            <label for="floatingInput">{{ __('Título') }}</label>

                            @if ($errors->first('titulo'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('titulo') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-floating mb-3 mx-5">
                            <input type="slug" class="form-control" name="slug" id="slug" value="{{ old('slug') ?? $post->slug }}" placeholder="Ingrese Slug" maxlength="150" required>
                            <label for="floatingInput">{{ __('Slug') }}</label>

                            @if ($errors->first('slug'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('slug') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-floating mb-3 mx-5">
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese Descripción" maxlength="10000" required style="height: 120px">{{ old('descripcion') ?? $post->descripcion }}</textarea>
                            <label for="floatingInput">{{ __('Descripción') }}</label>

                            @if ($errors->first('descripcion'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('descripcion') }}
                                </div>
                            @endif
                        </div>
                        
                        @if ($post->imagen)
                            <div class="form-group row mb-3 mx-5">
                                <div class="col-md-2">
                                    <img src="{{ asset ('/storage/'. $post->imagen) }}" width="100" height="100">
                                </div>
                                <div class="col-md-10 py-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="deleteImagen" name="deleteImagen" aria-label="Floating label select example">
                                            <option value="false" selected>No</option>
                                            <option value="true">Sí</option>
                                        </select>
                                        <label for="floatingSelect">Eliminar imagen actual</label>
                                    </div>
                                </div>

                                @if ($errors->first('deleteImagen'))
                                    <div class="alert alert-danger errorForm">
                                        {{ $errors->first('deleteImagen') }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="mb-3 mx-5">
                            <input type="file" class="form-control" name="imagen" id="imagen" style="display:none;">

                            @if ($errors->first('imagen'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('imagen') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-4 col-md-2">
                              <a style="text-decoration:none" onclick="history.back()">
                                <button type="button" class="btn btn-secondary">
                                  Volver
                                </button>
                              </a>
                            </div>

                            <div class="col">
                              <button type="submit" class="btn btn-success">
                                {{ __('Guardar') }}
                              </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script para filtrar habilitar los input montoInteresGrupoFamiliar y cantidadIntegrantes -->
<script src="{{ asset('js/editar-post.js') }}"></script>

@stop
