<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        //busco todos los post
        $posts = Post::all();

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
          ];
  
        //valido los datos ingresados
        $validacion = Validator::make($request->all(), [
            'titulo' => 'required|max:150',
            'slug' => 'required|max:150|unique:post',
            'descripcion' => 'required|max:10000'
        ], $messages);

        //si la validacion falla vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        //almaceno el post
        $post = new Post();
        $post->create($request->all());

        $postRetornado = Post::where('slug', $request->slug)->first();

        //redirijo para mostrar el post ingresado
        return redirect()->action('PostController@getShowId', $postRetornado->slug);
    }


    public function getShowId($slug)
    {
        //busco el post
        $post = Post::where('slug', $slug)->first();

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
            'slug' => [
                'required',
                'max:150',
                Rule::unique('post')->ignore($request->id),
              ],
            'descripcion' => 'required|max:10000'
        ], $messages);

        //si la validacion falla vuelvo hacia atras con los errores
        if($validacion->fails()){
            return redirect()->back()->withInput()->withErrors($validacion->errors());
        }

        //actualizo el post
        Post::where('id', $request->id)
              ->update([
                'titulo' => $request->titulo,
                'slug' => $request->slug,
                'descripcion' => $request->descripcion
              ]);


        //redirijo para mostrar el post actualizado
        return redirect()->action('PostController@getShowId', $request->slug);
    }
}
