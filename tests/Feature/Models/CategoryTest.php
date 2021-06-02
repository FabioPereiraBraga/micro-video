<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;
   
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testCreateUuid()
    {
        $category = factory(Category::class)->create();
        $this->assertCount(36, str_split($category->id));
        $this->assertMatchesRegularExpression(
            "/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i",
            $category->id
        );
    }

    
    public function testCreateFieldDescription()
    {
        $category = factory(Category::class)
        ->create([
            'description'=>null
        ]);
        $this->assertNull($category->description);

        $category = $this->category::create([
            'name'=>'Teste category'
        ]);
        $category->refresh();
        $this->assertNull($category->description);

        $category = $this->category::create([
            'name'=>'Teste category',
            'description'=>'Teste Cadastro Description'
        ]);
        $category->refresh();
        $this->assertNotNull($category->description);
     

    }

    public function testCreateFieldIsActive()
    {
        $category = $this->category->create([
            'name'=>'Teste category'
        ]);
        $category->refresh();
        $this->assertTrue($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => false
        ]);
        $category->refresh();
        $this->assertFalse($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => 0
        ]);
        $category->refresh();
        $this->assertFalse($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => 1
        ]);
        $category->refresh();
        $this->assertTrue($category->is_active);

    }


    public function testUpdateFieldDescription()
    {
        $category = factory(Category::class)
        ->create([
            'description'=>null
        ]);

        $category->update(['description'=>'Description update']);
        $this->assertNotNull($category->description);

        $category = $this->category::create([
            'name'=>'Teste category'
        ]);
     
        $category->update(['description'=>'Description update']);
        $this->assertNotNull($category->description);

        $category = $this->category::create([
            'name'=>'Teste category',
            'description'=>'Teste Cadastro Description'
        ]);
        $category->update(['description'=>null]);
        $this->assertNull($category->description);
     

    }

    public function testUpdateFieldIsActive()
    {
        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active'=>false
        ]);
        $category->update(['is_active'=>true]);
        $this->assertTrue($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => true
        ]);
        $category->update(['is_active'=>false]);
        $this->assertFalse($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => 1
        ]);
        $category->update(['is_active'=>0]);
        $this->assertFalse($category->is_active);

        $category = $this->category->create([
            'name'=>'Teste category',
            'is_active' => 0
        ]);
        $category->update(['is_active'=>1]);
        $this->assertTrue($category->is_active);

    }

    public function testListIsCollection()
    {
        factory(Category::class, 10)->create();
        $categories = Category::all();
        $this->assertCount(10, $categories);
        $this->assertInstanceOf(Collection::class, $categories); 
    }

    public function testListFields()
    {
        factory(Category::class, 5)->create();
        $categories = Category::all();

        foreach($categories->toArray() as $category){
            $this->assertArrayHasKey('id', $category);
            $this->assertArrayHasKey('name', $category);
            $this->assertArrayHasKey('description', $category);
            $this->assertArrayHasKey('is_active', $category); 
            $this->assertArrayHasKey('deleted_at', $category); 
            $this->assertArrayHasKey('updated_at', $category); 
            $this->assertArrayHasKey('created_at', $category); 
        }
       
    }


    public function testDelete()
    {
        $category = factory(Category::class)->create();
        $category = Category::find($category->id);
        $categoryArray = $category->toArray();
        $category->delete();

        $this->assertDatabaseMissing('categories', $categoryArray);
    }
}
