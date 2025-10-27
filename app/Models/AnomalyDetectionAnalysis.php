<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnomalyDetectionAnalysis extends Model implements HasMedia
{
    use InteractsWithMedia;

    /** @use HasFactory<\Database\Factories\AnomalyDetectionAnalysisFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function analysis()
    {
        return $this->morphOne(Analysis::class, 'analyzable');
    }

    // public function modelResult(): Attribute
    // {
    //     return Attribute::get(fn($value) => json_decode($value));
    // }
}
