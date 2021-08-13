<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <!--conexion a los estilos css-->
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    

    @include('partials.header')
    <title>Site Posts</title>
</head>
<body>
    <div class="container">
        @yield('content')     <!--acá es sustituido por el contenido que se le indique -->
    </div>

    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- Links de dataTable -->
    <link rel="stylesheet" type="text/css" href="datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css"/>
    <script type="text/javascript" src="datatable/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="datatable/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>


    <!-- Link de js para la dataTable -->
    <script src="{{ asset('js/datatable.js') }}"></script>

</body>
</html>



