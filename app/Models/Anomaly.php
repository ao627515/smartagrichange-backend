<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function  anomaly()
    {
        return $this->belongsTo(Anomaly::class, 'anomaly_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('anomaly_images')
            ->useDisk(config('media-library.disk_name'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(200)
            ->height(150)
            ->nonQueued();
    }
}
