<?php

namespace App\DTO\Requests;


class PlantRequestDto
{
    public function __construct(
        public string $common_name,
        public string $scientific_name,
        public ?string $family,
        public ?string $type,
        public ?string $life_cycle,
        public ?string $geographical_zone,
    ) {}
}
