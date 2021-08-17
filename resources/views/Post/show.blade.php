@extends('master')

@section('content')

<div class="cuadro">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ $post->titulo }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ $post->slug }}</h6>
      <p class="card-text">{!! nl2br($post->descripcion) !!}</p>
      <h6 class="card-subtitle mb-2 text-muted text-end">{{ 'Fecha de Creación: ' . $post->created }}</h6>
      <h6 class="card-subtitle mb-2 text-muted text-end">{{ 'Fecha de Modificación: ' .$post->modified }}</h6>
      
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
          <form action="{{ url('/delete') }}" method="post" style="display:inline">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $post->slug }}">
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
