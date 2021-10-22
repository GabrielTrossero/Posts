<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'descripcion' => $this->descripcion,
            'imagen' => $this->imagen,
            'created' => $this->created->format('d-m-Y H:i:s'),
            'updated' => $this->modified, //no le puedo poner formato porque a veces es null
        ];
    }
}
