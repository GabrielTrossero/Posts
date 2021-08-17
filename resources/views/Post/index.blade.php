@extends('master')

@section('content')


<div class="cuadro">
  <div class="card">
    <div class="card-header row"> <!--row me permite mantener los dos label en la misma linea-->
        <label class="col-md-10 col-form-label"><b>Listado de Posts</b></label>
        <label class="col-md-2 col-form-label">
        <a style="text-decoration:none" href="{{ url('/create') }}">
            <button type="button" class="btn btn-success" style="display:inline">
                Agregar Post
            </button>
        </a>
      </label>
    </div>
    <div class="card-body border">
    <table id="idDataTable" class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha de Creación</th>
                <th>Descripción</th>
                <th>Más Información</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->titulo }}</td>
                    <td>{{ $post->created }}</td>
                    <td>{{ $post->descripcion }}</td>
                    <td><a href="{{ url('/show/'.$post->slug) }}"> <i class="bi bi-plus-lg"></i></a> </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
    </div>
  </div>
</div>



@stop