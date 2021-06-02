<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testFillable(): void
    {
    
       $this->assertEquals([
        'name',
        'description',
        'is_active'
       ],
       $this->category->getFillable()
     );

    }

    public function testDates(): void
    {
       
    $this->assertEquals([
        'deleted_at',
        'created_at',
        'updated_at'
    ], 
     $this->category->getDates());
     

    }

    public function testCasts(): void
    {
     
     $this->assertEquals([
        'description' => 'string',
        'id'=>'string',
        'name' => 'string',
        'is_active' => 'bollean'
     ],
     $this->category->getCasts()
     );

    }

    public function testIfUserTraits(): void
    {
        $traisCategoria = array_values(class_uses($this->category));
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];

       $this->assertEqualsCanonicalizing(
        $traits,
        $traisCategoria
       );

    }

    public function testIncrementing()
    {
       $this->assertFalse($this->category->incrementing);
    }

    public function testKeyType()
    {
        $this->assertEquals('string', $this->category->getKeyType());
    }


}
