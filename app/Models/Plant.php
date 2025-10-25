<?php

namespace App\Models;

use App\Models\Rubric;
use App\Models\Anomaly;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model implements HasMedia
{
    use InteractsWithMedia;

    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rubrics()
    {
        return $this->hasMany(Rubric::class, 'plant_id', 'id');
    }

    public function anomalies()
    {
        return $this->hasMany(Anomaly::class, 'plant_id');
    }
}
