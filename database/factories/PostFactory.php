<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /**
         * Faker es una librería de PHP que te permite obtener distintos tipos de datos para las
         * columnas de tus tablas
         */
        return [
            'titulo' => $this->faker->catchPhrase(),
            'slug' => $this->faker->slug(),
            'descripcion' => $this->faker->realText($maxNbChars = 600),
        ];
    }
}
