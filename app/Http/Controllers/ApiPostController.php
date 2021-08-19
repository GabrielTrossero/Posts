<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Post;

class ApiPostController extends Controller
{
    public function list()
    {
        //busco todos los post
        $posts = Post::all();

        //cambio las fechas de formato
        foreach ($posts as $post) {
            $post->created = Carbon::parse($post->created)->format('d-m-Y H:i:s');
        }

        return response()->json($posts);
    }


    public function create(Request $request){
        //mensajes de error que se mostraran por pantalla
        $messages = [
            'titulo.required' => 'Es necesario ingresar un Título.',
            'titulo.max' => 'Es necesario ingresar un Título válido.',
            'slug.required' => 'Es necesario ingresar un Slug.',
            'slug.unique' => 'Ingrese un Slug válido. Ya existe un Post con dicho Slug.',
            'slug.max' => 'Es necesario ingresar un Slug válido.',
            'descripcion.required' => 'Es necesario ingresar una Descripción.',
            'descripcion.max' => 'Ingrese una Descripción válida.',
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'titulo' => 'required|max:150',
            'slug' => 'required|max:150|unique:post',
            'descripcion' => 'required|max:10000'
        ], $messages);

        //si la validacion falla devuelvo error
        if($validacion->fails()){
            if ($validacion->errors()->first('titulo')) {
                return response()->json([
                    'message' => $validacion->errors()->first('titulo')
                ], 400);
            }
            elseif ($validacion->errors()->first('slug')) {
                return response()->json([
                    'message' => $validacion->errors()->first('slug')
                ], 400);
            }
            elseif ($validacion->errors()->first('descripcion')) {
                return response()->json([
                    'message' => $validacion->errors()->first('descripcion')
                ], 400);
            }
        }

        //almaceno el post
        $post = new Post();
        $post->create($request->all());

        return response()->json([
            'message' => 'Post creado correctamente'
        ], 201);
    }


    public function update(Request $request){
        //mensajes de error que se mostraran por pantalla
        $messages = [
            'id.required' => 'Es necesario ingresar el id.',
            'id.exists' => 'El id ingresado es incorrecto.',
            'titulo.required' => 'Es necesario ingresar un Título.',
            'titulo.max' => 'Es necesario ingresar un Título válido.',
            'slug.required' => 'Es necesario ingresar un Slug.',
            'slug.unique' => 'Ingrese un Slug válido. Ya existe un Post con dicho Slug.',
            'slug.max' => 'Es necesario ingresar un Slug válido.',
            'descripcion.required' => 'Es necesario ingresar una Descripción.',
            'descripcion.max' => 'Ingrese una Descripción válida.',
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:post',
            'titulo' => 'required|max:150',
            'slug' => [
                'required',
                'max:150',
                Rule::unique('post')->ignore($request->id),
              ],
            'descripcion' => 'required|max:10000'
        ], $messages);

        //si la validacion falla devuelvo error
        if($validacion->fails()){
            if ($validacion->errors()->first('id')) {
                return response()->json([
                    'message' => $validacion->errors()->first('id')
                ], 400);
            }
            elseif ($validacion->errors()->first('titulo')) {
                return response()->json([
                    'message' => $validacion->errors()->first('titulo')
                ], 400);
            }
            elseif ($validacion->errors()->first('slug')) {
                return response()->json([
                    'message' => $validacion->errors()->first('slug')
                ], 400);
            }
            elseif ($validacion->errors()->first('descripcion')) {
                return response()->json([
                    'message' => $validacion->errors()->first('descripcion')
                ], 400);
            }
        }

        //actualizo el post
        Post::where('id', $request->id)
            ->update([
                'titulo' => $request->titulo,
                'slug' => $request->slug,
                'descripcion' => $request->descripcion
            ]);


        return response()->json([
            'message' => 'Post actualizado correctamente'
        ], 201);
    }


    public function destroy(Request $request)
    {
        //mensajes de error que se mostraran por pantalla
        $messages = [
            'id.required' => 'Es necesario ingresar el id.',
            'id.exists' => 'El id ingresado es incorrecto.'
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:post'
        ], $messages);

        //si la validacion falla devuelvo error
        if($validacion->fails()){
            if ($validacion->errors()->first('id')) {
                return response()->json([
                    'message' => $validacion->errors()->first('id')
                ], 400);
            }
        }

        //elimino el registro con tal id
        $post = post::destroy($request->id);

        return response()->json([
            'message' => 'Post eliminado correctamente'
        ], 201);
    }
}
