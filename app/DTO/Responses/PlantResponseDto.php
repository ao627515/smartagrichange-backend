<?php

namespace App\DTO\Responses;

use Spatie\LaravelData\Data;

class PlantResponseDto extends Data
{
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
    ) {}

    public static function fromModel($plant): self
    {
        return new self(
            id: $plant->id,
            common_name: $plant->common_name,
            scientific_name: $plant->scientific_name,
            family: $plant->family,
            type: $plant->type,
            life_cycle: $plant->life_cycle,
            geographical_zone: $plant->geographical_zone,
            created_at: $plant->created_at,
            updated_at: $plant->updated_at
        );
    }
}
