<?php

namespace App\Models;

use App\Models\RubricInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubric extends Model
{
    /** @use HasFactory<\Database\Factories\RubricFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function infos(){
        return $this->hasMany(RubricInfo::class, 'rubric_id', 'id');
    }
}
