@extends('master')

@section('content')

<div class="cuadro">
  <div class="card">
    <div class="card-body">
      @if (Session::has('danger'))
          <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      @if (Session::has('alert'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      <h5 class="card-title text-success">{{ $post->titulo }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ $post->slug }}</h6>
      @if ($post->imagen)
          <img style="float:left" class="p-2" src="{{ asset ('/storage/'. $post->imagen) }}" width="200" height="200">
      @endif
      <p class="card-text">{!! nl2br($post->descripcion) !!}</p>

      <div style="clear:both"></div>
      
      <h6 class="card-subtitle mb-2 text-muted text-end">{{ 'Fecha de Creación: ' . $post->created }}</h6>
      @if ($post->modified)
        <h6 class="card-subtitle mb-2 text-muted text-end">{{ 'Fecha de Modificación: ' .$post->modified }}</h6>
      @else
        <h6 class="card-subtitle mb-2 text-muted text-end">{{ 'Fecha de Modificación: Sin modificar' }}</h6>
      @endif
      
      <div class="row">
        <div class="col-sm-1">
          <a style="text-decoration:none" onclick="history.back()">
            <button type="button" class="btn btn-secondary">
              Volver
            </button>
          </a>
        </div>
        <div class="col-sm-10 text-center">
          <a style="text-decoration:none" href="{{ url('/edit/'.$post->slug) }}">
            <button type="button" class="btn btn-outline-warning" style="display:inline">
              Editar Post
            </button>
          </a>
          &nbsp;&nbsp;
          <form action="{{ url('/delete') }}" method="post" style="display:inline" onsubmit="return confirm('¿Está seguro que desea eliminar el Post?');">
            @csrf
            @method('delete')
            <input type="hidden" name="id" value="{{ $post->id }}">
            <button type="submit" class="btn btn-outline-danger" style="display:inline">
              Eliminar Post
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
