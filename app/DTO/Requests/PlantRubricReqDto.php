<?php

namespace App\DTO\Requests;

use Spatie\LaravelData\Data;


class PlantRubricReqDto extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public int $plant_id,
    ) {}
}
