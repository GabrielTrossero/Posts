<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMailRequest;

class MailController extends Controller
{
    public function index()
    {
        return view('mail.contact');
    }


    public function store(StoreMailRequest $request)
    {
        $correo = $request->validated();
/*
        //mensajes de error que se mostraran por pantalla
        $messages = [
            'nombre.required' => 'Es necesario ingresar un Nombre.',
            'nombre.max' => 'Es necesario ingresar un Nombre válido.',
            'correo.required' => 'Es necesario ingresar un Correo Electrónico.',
            'correo.max' => 'Es necesario ingresar un Correo Electrónico válido.',
            'mensaje.required' => 'Es necesario ingresar una Descripción.',
            'mensaje.max' => 'Ingrese una Descripción válida.',
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'correo' => 'required|max:50',
            'mensaje' => 'required|max:10000'
        ], $messages);

        //si la validacion falla vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }*/

        //genero el correo y le paso los datos
        $correo = new ContactMail($request);

        //envío el correo
        Mail::to('gabrieltrosserogetr@gmail.com')->send($correo);

        //return redirect()->action('PostController@index')->with('alert', 'Correo enviado correctamente');
        return redirect(route('post.index'))->with('alert', 'Correo enviado correctamente correctamente');
    }
}
