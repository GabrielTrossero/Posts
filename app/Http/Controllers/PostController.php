<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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


    public function store(StorePostRequest $request){

        $post = $request->validated();

        if ($request->hasFile('imagen')) {
            $post['imagen'] = $this->addImage_Post($request);
        }
        else {
            $post['imagen'] = null;
        }

        Post::create($post);

        $postRetornado = Post::where('slug', $request->slug)->first();

        //redirijo para mostrar el post ingresado
        return redirect(route('post.showId',['slug' => $postRetornado->slug]))->with('alert', 'Post generado correctamente');
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


    public function update(UpdatePostRequest $request){

        $post = $request->validated();

        $postOriginal = Post::find($request->id);
        
        
        if ($postOriginal->imagen) { //si tenía imagen anteriormente
            if ($post['deleteImagen'] == 'true') { //si quiere eliminar la imagen vieja
                $post['imagen'] = $this->deleteImage_Post($postOriginal); //borro la imagen del storage y del post
                
                if ($request->hasFile('imagen')) { //si quiere agregar una nueva imagen
                    $post['imagen'] = $this->addImage_Post($request);
                }
            }
        }
        else { //si no tenía imagen anteriormente
            if ($request->hasFile('imagen')) { //si quiere agregar una nueva
                $post['imagen'] = $this->addImage_Post($request);
            }
        }


        $postOriginal->update($post);
        
        //redirijo para mostrar el post actualizado
        return redirect(route('post.showId',['slug' => $postOriginal->slug]))->with('alert', 'Post actualizado correctamente');
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
