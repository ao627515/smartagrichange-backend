<?php

namespace App\Models;

use App\Models\RubricInfo;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubric extends Model
{
    /** @use HasFactory<\Database\Factories\RubricFactory> */
    use HasFactory, HasUlids;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    // protected $inc
    protected $keyType = 'string';
    public $incrementing = false;



    public function infos()
    {
        return $this->hasMany(RubricInfo::class, 'rubric_id', 'id');
    }
}
