<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use App\DTO\Req\PlantRubricWithoutPlantIdReqDto;


class PlantRequestDto extends Data
{
    /**
     * Summary of __construct
     * @param string $common_name
     * @param string $scientific_name
     * @param string|null $family
     * @param string|null $type
     * @param string|null $life_cycle
     * @param string|null $geographical_zone
     * @param array<int, PlantRubricWithoutPlantIdReqDto>|null $rubrics
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