<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricInfo extends Model
{
    /** @use HasFactory<\Database\Factories\RubricInfoFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
