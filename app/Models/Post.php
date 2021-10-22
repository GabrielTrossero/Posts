<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = "post";
    
    public $timestamps = false;

    protected $fillable = [
        'titulo', 'slug', 'descripcion', 'imagen', 'created', 'modified'
    ];

    /**
     * The attributes that should be mutated to dates.
     * Nota: esto para que ande PostResource con el formato de la fechas
     *
     * @var array
     */
    protected $dates = ['created', 'modified'];
}
