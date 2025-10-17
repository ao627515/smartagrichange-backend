<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnomalyDetectionAnalysis extends Model
{
    /** @use HasFactory<\Database\Factories\AnomalyDetectionAnalysisFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function analysis()
    {
        return $this->morphOne(Analysis::class, 'analyzable');
    }
}
