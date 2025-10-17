<?php

namespace App\Models;

use App\Models\Analysis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoilAnalysis extends Model
{
    /** @use HasFactory<\Database\Factories\SoilAnalysisFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function analysis()
    {
        return $this->morphOne(Analysis::class, 'analyzable');
    }
}
