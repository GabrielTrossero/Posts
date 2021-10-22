<?php
namespace App\Traits;

trait Image {
    //funcion que agrega una nueva imagen al storage y devuelve el path
    public function addImage($request)
    {
        $path = $request->file('imagen')->store('public'); //almaceno la imagen
        $path = substr($path, 7); //el path original es "public/img.jpg". Entonces le dejo solo: "img.jpg"

        return $path;
    }


    //funcion que borra la imagen del storage y del post
    public function deleteImage($post)
    {
        //compruebo que tenga imagen
        if($post->imagen){
            unlink(storage_path('app/public/'.$post->imagen)); //borro la imagen del storage
    
            $post->imagen = null; //borro la imagen del post
        }

        return null;
    }
}