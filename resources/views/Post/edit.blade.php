@extends('master')

@section('content')

<div class="cuadro">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar Post') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/edit') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ $post->id }}">

                        @if (Session::has('danger'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ Session::get('danger') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
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

@stop
