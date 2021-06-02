<?php

namespace Tests\Unit\Model;

use App\Models\Genre;
use Tests\TestCase;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenreTest extends TestCase
{
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testFillable(): void
    {
    
       $this->assertEquals([
        'name',
        'is_active'
       ],
       $this->genre->getFillable()
     );

    }

    public function testDates(): void
    {
       
    $this->assertEquals([
        'deleted_at',
        'created_at',
        'updated_at'
    ], 
     $this->genre->getDates());
     

    }

    public function testCasts(): void
    {
     
     $this->assertEquals([
        'id'=>'string',
        'name'=>'string',
        'is_active'=>'bollean'
     ],
     $this->genre->getCasts()
     );

    }

    public function testIfUserTraits(): void
    {
        $traisCategoria = array_values(class_uses($this->genre));
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
       $this->assertFalse($this->genre->incrementing);
    }

    public function testKeyType()
    {
        $this->assertEquals('string', $this->genre->getKeyType());
    }


}
