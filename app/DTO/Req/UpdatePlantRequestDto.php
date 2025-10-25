<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;

class UpdatePlantRequestDto extends Data
{
    /**
     * Summary of __construct
     * @param string $common_name
     * @param string $scientific_name
     * @param ?string $family
     * @param ?string $type
     * @param ?string $life_cycle
     * @param ?string $geographical_zone
     * @param ?array<int,  PlantRubricWithIdReqDto> $rubrics
     */
    public function __construct(
        public string $common_name,
        public string $scientific_name,
        public ?string $family,
        public ?string $type,
        public ?string $life_cycle,
        public ?string $geographical_zone,
        public ?array $rubrics,
    ) {}
}