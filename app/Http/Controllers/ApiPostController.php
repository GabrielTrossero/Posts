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
            'imagen.image' => "El archivo debe ser una Imagen."
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'titulo' => 'required|max:150',
            'slug' => 'required|max:150|unique:post',
            'descripcion' => 'required|max:10000',
            'imagen' => 'image'
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
            elseif ($validacion->errors()->first('imagen')) {
                return response()->json([
                    'message' => $validacion->errors()->first('imagen')
                ], 400);
            }
        }

        //si ingresó imagen
        if ($request->hasFile('imagen')) {
            $path = $this->addImage($request);
        }
        else {
            $path = null;
        }

        //almaceno el post
        $post = new Post();
        $post->titulo = $request->titulo;
        $post->slug = $request->slug;
        $post->descripcion = $request->descripcion;
        $post->imagen = $path;
        $post->save();

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
            'deleteImagen.in' => 'DeleteImagen: Dicha opción no es válida.',
            'imagen.image' => "El archivo debe ser una Imagen."
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
            'descripcion' => 'required|max:10000',
            'deleteImagen' => 'in:true,false',
            'imagen' => 'image'
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
            elseif ($validacion->errors()->first('deleteImagen')) {
                return response()->json([
                    'message' => $validacion->errors()->first('deleteImagen')
                ], 400);
            }
            elseif ($validacion->errors()->first('imagen')) {
                return response()->json([
                    'message' => $validacion->errors()->first('imagen')
                ], 400);
            }
        }

        $postOriginal = Post::find($request->id);
        
        if ($postOriginal->imagen) { //si tenía imagen anteriormente
            if ($request->deleteImagen == 'true') { //si quiere eliminar la imagen vieja
                $postOriginal = $this->removeImage($postOriginal); //borro la imagen del storage y del post
                
                if ($request->hasFile('imagen')) { //si quiere agregar una nueva imagen
                    $postOriginal->imagen = $this->addImage($request);
                }
            }
        }
        else { //si no tenía imagen anteriormente
            if ($request->hasFile('imagen')) { //si quiere agregar una nueva
                $postOriginal->imagen = $this->addImage($request);
            }
        }

        //actualizo el post
        $postOriginal->titulo = $request->titulo;
        $postOriginal->slug = $request->slug;
        $postOriginal->descripcion = $request->descripcion;
        $postOriginal->save();

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

        $post = Post::find($request->id);

        //borro la imagen del storage
        $this->removeImage($post);

        //elimino el registro con tal id
        Post::destroy($request->id);

        return response()->json([
            'message' => 'Post eliminado correctamente'
        ], 201);
    }

    
    //funcion que agrega una nueva imagen al storage y devuelve el path
    public function addImage($request)
    {
        $path = $request->file('imagen')->store('public'); //almaceno la imagen
        $path = substr($path, 7); //el path original es "public/img.jpg". Entonces le dejo solo: "img.jpg"

        return $path;
    }


    //funcion que borra la imagen del storage y del post
    public function removeImage($post)
    {
        unlink(storage_path('app/public/'.$post->imagen)); //borro la imagen del storage

        $post->imagen = null; //borro la imagen del post

        return $post;
    }
}
