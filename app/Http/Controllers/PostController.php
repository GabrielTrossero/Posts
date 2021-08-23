<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Traits\Image;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        //busco todos los post
        $posts = Post::all();

        //cambio las fechas de formato
        foreach ($posts as $post) {
            $post->created = Carbon::parse($post->created)->format('d-m-Y H:i:s');
        }

        //redirijo a la vista para listar todos los post pasandole el array "post"
        return view('post.index' , compact('posts'));
    }


    public function create()
    {
        //redirijo a la vista para agregar un post
        return view('post.create');
    }


    public function store(Request $request){
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

        //si la validacion falla vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        //si ingresó imagen
        if ($request->hasFile('imagen')) {
            $path = $this->addImage_Post($request);
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

        $postRetornado = Post::where('slug', $request->slug)->first();

        //redirijo para mostrar el post ingresado
        return redirect()->action('PostController@getShowId', $postRetornado->slug)->with('alert', 'Post generado correctamente');;
    }


    public function getShowId($slug)
    {
        //busco el post
        $post = Post::where('slug', $slug)->first();

        //cambio las fechas de formato
        $post->created = Carbon::parse($post->created)->format('d-m-Y H:i:s');
        if ($post->modified) {
            $post->modified = Carbon::parse($post->modified)->format('d-m-Y H:i:s');
        }
        //redirijo a la vista individual con los datos del post
        return view('post.show' , ['post' => $post]);
    }


    public function edit($slug)
    {
        //busco el registro
        $post = Post::where('slug', $slug)->first();

        //redirijo al formulario de edicion con los datos del post
        return view('post.edit' , ['post' => $post]);
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
            'deleteImagen.required' => 'Es necesario ingresar una opción.',
            'deleteImagen.in' => 'Dicha opción no es válida.',
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
            'deleteImagen' => 'required_if:selectIsRequired,==,true|in:true,false', //solo es required cuando había una imagen en el post
            'imagen' => 'image'
        ], $messages);

        //si la validacion falla con el id, vuelvo hacia atras
        if($validacion->errors()->first('id')){
            return redirect()->back()->with('danger', 'ERROR: El Post no se pudo actualizar');
        }

        //si la validacion falla con otro campo, vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        $postOriginal = Post::find($request->id);
        
        if ($postOriginal->imagen) { //si tenía imagen anteriormente
            if ($request->deleteImagen == 'true') { //si quiere eliminar la imagen vieja
                $postOriginal = $this->deleteImage_Post($postOriginal); //borro la imagen del storage y del post
                
                if ($request->hasFile('imagen')) { //si quiere agregar una nueva imagen
                    $postOriginal->imagen = $this->addImage_Post($request);
                }
            }
        }
        else { //si no tenía imagen anteriormente
            if ($request->hasFile('imagen')) { //si quiere agregar una nueva
                $postOriginal->imagen = $this->addImage_Post($request);
            }
        }

        //actualizo el post
        $postOriginal->titulo = $request->titulo;
        $postOriginal->slug = $request->slug;
        $postOriginal->descripcion = $request->descripcion;
        $postOriginal->save();


        //redirijo para mostrar el post actualizado
        return redirect()->action('PostController@getShowId', $request->slug)->with('alert', 'Post actualizado correctamente');
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

        //si la validacion falla vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->with('danger', 'ERROR: El Post no se pudo eliminar');
        }

        $post = Post::find($request->id);

        //borro la imagen del storage
        $this->deleteImage_Post($post);

        //elimino el registro con tal id
        Post::destroy($request->id);

        //redirijo al listado
        return redirect()->action('PostController@index')->with('alert', 'Post eliminado correctamente');
    }

    //Utilizo la clase Image para intanciar las funciones addImage y deleteImage
    use Image;

    public function addImage_Post($request)
    {
        return $this->addImage($request);
    }

    public function deleteImage_Post($post)
    {
        return $this->deleteImage($post);
    }
}
