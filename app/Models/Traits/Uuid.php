<?
namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as UuidRamsey;


trait Uuid {

 
    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->id = UuidRamsey::uuid4();
        });
    }
}