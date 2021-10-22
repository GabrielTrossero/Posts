<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Traits\Image;
use App\Models\Post;

class ApiPostController extends Controller
{
    public function list()
    {
        return response()->json(new PostCollection(Post::all()));
    }

    public function showId(Request $request)
    {
        return response()->json(new PostResource(Post::where('slug', $request->slug)->first()));
    }


    public function create(StorePostRequest $request){

        $post = $request->validated();

        //si ingresó imagen
        if ($request->hasFile('imagen')) {
            $post['imagen'] = $this->addImage_Post($request);
        }
        else {
            $post['imagen'] = null;
        }

        Post::create($post);

        return ['created' => true];
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

        return ['updated' => true];
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
        $this->deleteImage_Post($post);

        //elimino el registro con tal id
        Post::destroy($request->id);

        return response()->json([
            'message' => 'Post eliminado correctamente'
        ], 201);
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
