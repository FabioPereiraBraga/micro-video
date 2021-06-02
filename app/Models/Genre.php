<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use Uuid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'id'=>'string',
        'name'=>'string',
        'is_active'=>'boolean'
    ];
}
