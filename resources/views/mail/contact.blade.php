@extends('master')

@section('content')

<div class="cuadro">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Contactar') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/contact') }}">
                        {{ csrf_field() }}

                        <div class="form-floating mb-3 mx-5">
                            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ingrese Nombre" maxlength="100" required>
                            <label for="floatingInput">{{ __('Nombre y Apellido') }}</label>

                            @if ($errors->first('nombre'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('nombre') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-floating mb-3 mx-5">
                            <input type="email" class="form-control" name="correo" id="correo" value="{{ old('correo') }}" placeholder="Ingrese Correo" maxlength="50" required>
                            <label for="floatingInput">{{ __('Correo Electrónico') }}</label>

                            @if ($errors->first('correo'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('correo') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-floating mb-3 mx-5">
                            <textarea class="form-control" name="mensaje" id="mensaje" placeholder="Ingrese Mensaje" maxlength="10000" required style="height: 120px">{{ old('mensaje') }}</textarea>
                            <label for="floatingInput">{{ __('Mensaje') }}</label>

                            @if ($errors->first('mensaje'))
                                <div class="alert alert-danger errorForm">
                                    {{ $errors->first('mensaje') }}
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
                                {{ __('Enviar') }}
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
