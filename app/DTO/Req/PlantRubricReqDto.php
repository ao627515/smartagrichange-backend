<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;


class PlantRubricReqDto extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public int $plant_id,
    ) {}
}
