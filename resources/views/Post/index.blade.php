@extends('master')

@section('content')


<div class="cuadro">
  <div class="card">
    <div class="card-header row"> <!--row me permite mantener los dos label en la misma linea-->
        <label class="col-md-10 col-form-label"><b>Listado de Posts</b></label>
        <label class="col-md-2 col-form-label">
        <a style="text-decoration:none" href="{{ url('/') }}">
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
            <tr>
                <td>Las PC de la nueva generación</td>
                <td>27/05/21</td>
                <td>Como cada día, las PC avanzan a pasos gigantados, esto gracias a ...</td>
            </tr>
            <tr>
                <td>Programar fácil</td>
                <td>20/11/20</td>
                <td>Quieres programar de forma fácil? Entonces empezemos ...</td>
            </tr>
        </tbody>
    </table>

   
    </div>
  </div>
</div>



@stop