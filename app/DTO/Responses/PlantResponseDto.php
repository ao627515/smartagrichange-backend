<?php

namespace App\DTO\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PlantResponseDto extends Data
{
    public array $images = [];

    public function __construct(
        public int $id,
        public string $common_name,
        public string $scientific_name,
        public ?string $family,
        public ?string $type,
        public ?string $life_cycle,
        public ?string $geographical_zone,
        public ?string $created_at,
        public ?string $updated_at,
        public Lazy|array $rubrics
    ) {}

    public static function fromModel($plant): self
    {


        $m = new self(
            id: $plant->id,
            common_name: $plant->common_name,
            scientific_name: $plant->scientific_name,
            family: $plant->family,
            type: $plant->type,
            life_cycle: $plant->life_cycle,
            geographical_zone: $plant->geographical_zone,
            created_at: $plant->created_at,
            updated_at: $plant->updated_at,
            rubrics: Lazy::whenLoaded('rubrics', $plant, fn() => $plant->rubrics->toArray())
        );

        $m->images = $plant->getMedia('plant_images')
            ->map(fn(Media $media) => $media->getFullUrl())
            ->toArray();

        return $m;
    }
}
