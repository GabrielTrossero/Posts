<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_HTTP_API_post()
    {
        $response = $this->postJson('/api/post/create', ['slug' => 'a', 'titulo' => 'a', 'descripcion' => 'a']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }


    public function test_HTTP_API_get()
    {
        $response = $this->postJson('api/post/showId', ['slug' => 'a']);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', 50)
                    ->where('slug', 'a')
                    ->where('titulo', 'a')
                    ->where('descripcion', 'a')
                    ->etc()
            );
    }
}
