<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gender extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $dates = [
    'deleted_at'
    ];
    protected $casts = [
        'id'=>'string'
    ];
}
