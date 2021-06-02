<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;

class GenreTest extends TestCase
{

    use DatabaseMigrations;
   
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testCreateUuid()
    {
        $genre = factory(Genre::class)->create();
        $this->assertCount(36, str_split($genre->id));
        $this->assertMatchesRegularExpression(
            "/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i",
            $genre->id
        );
    }


    public function testCreateFieldIsActive()
    {
        $genre = $this->genre->create([
            'name'=>'Teste genre'
        ]);
        $genre->refresh();
        $this->assertTrue($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => false
        ]);
        $genre->refresh();
        $this->assertFalse($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => 0
        ]);
        $genre->refresh();
        $this->assertFalse($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => 1
        ]);
        $genre->refresh();
        $this->assertTrue($genre->is_active);

    }

    public function testUpdateFieldIsActive()
    {
        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active'=>false
        ]);
        $genre->update(['is_active'=>true]);
        $this->assertTrue($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => true
        ]);
        $genre->update(['is_active'=>false]);
        $this->assertFalse($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => 1
        ]);
        $genre->update(['is_active'=>0]);
        $this->assertFalse($genre->is_active);

        $genre = $this->genre->create([
            'name'=>'Teste genre',
            'is_active' => 0
        ]);
        $genre->update(['is_active'=>1]);
        $this->assertTrue($genre->is_active);

    }

    public function testListIsCollection()
    {
        factory(Genre::class, 10)->create();
        $categories = Genre::all();
        $this->assertCount(10, $categories);
        $this->assertInstanceOf(Collection::class, $categories); 
    }

    public function testListFields()
    {
        factory(Genre::class, 5)->create();
        $categories = Genre::all();

        foreach($categories->toArray() as $genre){
            $this->assertArrayHasKey('id', $genre);
            $this->assertArrayHasKey('name', $genre);
            $this->assertArrayHasKey('is_active', $genre); 
            $this->assertArrayHasKey('deleted_at', $genre); 
            $this->assertArrayHasKey('updated_at', $genre); 
            $this->assertArrayHasKey('created_at', $genre); 
        }
       
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();
        $genre = Genre::find($genre->id);
        $genreArray = $genre->toArray();
        $genre->delete();

        $this->assertDatabaseMissing('genres', $genreArray);
    }
}
