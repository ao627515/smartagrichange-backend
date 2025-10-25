<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricInfo extends Model
{
    /** @use HasFactory<\Database\Factories\RubricInfoFactory> */
    use HasFactory, HasUlids;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $keyType = 'string';
    public $incrementing = false;
}
