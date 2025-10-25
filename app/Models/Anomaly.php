<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anomaly extends Model implements HasMedia
{
    use InteractsWithMedia;

    /** @use HasFactory<\Database\Factories\AnomalyFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
