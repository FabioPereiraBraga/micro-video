<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    use DatabaseMigrations;
  
    public function testIndex()
    {
        $genres = factory(Genre::class)->create();

        $response = $this->get(route('genres.index'));


        $response->assertStatus(200);
        $response->assertJson([$genres->toArray()]);
    }

    public function testShow()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->get(route('genres.show', ['genre'=>$genre->id] ));


        $response->assertStatus(200);
        $response->assertJson($genre->toArray());
    }

    public function testDestroy()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', ['genre'=>$genre->id]));
        $response->assertNoContent(204);
    }

    public function testStore()
    {
        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
        ]);
        $response->assertStatus(201);
        $this->assertTrue($response->json('is_active'));
        $this->assertEquals('a', $response->json('name'));
        $this->assertNull($response->json('description'));

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=> 0
        ]);

        $this->assertFalse($response->json('is_active'));

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=> false
        ]);

        $this->assertFalse($response->json('is_active'));

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=> 1
        ]);

        $this->assertTrue($response->json('is_active'));

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=> true
        ]);

        $this->assertTrue($response->json('is_active'));

    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name'=>'teste',
            'is_active'=> true
        ]);

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name'=>'teste update',
        ]);
        $response->assertStatus(200);
        $this->assertTrue($response->json('is_active'));
        $this->assertEquals('teste update', $response->json('name'));
        $this->assertNull($response->json('description'));

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name'=>'teste update is_active',
            'is_active'=> 0
        ]);

        $this->assertFalse($response->json('is_active'));

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name'=>'teste update is_active',
            'is_active'=> false
        ]);

        $this->assertFalse($response->json('is_active'));

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name'=>'teste update is_active',
            'is_active'=> 1
        ]);

        $this->assertTrue($response->json('is_active'));

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), [
            'name'=>'teste update is_active',
            'is_active'=> true
        ]);

        $this->assertTrue($response->json('is_active'));

    }

    public function testValidationFields()
    {
        $response = $this->json('POST', route('genres.store'), [
            'name'=>str_repeat('a', 256),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            Lang::get('validation.max.string',['attribute'=>'name','max'=>'255'])
         ]);

        $response = $this->json('POST', route('genres.store'), [
            'is_active'=>0
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            Lang::get('validation.required',['attribute'=>'name'])
         ]);

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=>'teste'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['is_active']);
        $response->assertJsonFragment([
            Lang::get('validation.boolean',['attribute'=>'is active'])
        ]);

        $response = $this->json('POST', route('genres.store'), [
            'name'=>'a',
            'is_active'=>2
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['is_active']);
        $response->assertJsonFragment([
            Lang::get('validation.boolean',['attribute'=>'is active'])
        ]);

    }
}
