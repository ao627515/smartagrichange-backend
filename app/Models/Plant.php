<?php

namespace App\Models;

use App\Models\Rubric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rubrics()
    {
        return $this->hasMany(Rubric::class, 'plant_id', 'id');
    }
}