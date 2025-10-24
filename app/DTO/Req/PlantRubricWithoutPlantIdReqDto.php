<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;


class PlantRubricWithoutPlantIdReqDto extends Data
{
    /**
     * Summary of __construct
     * @param string $name
     * @param mixed $description
     * @param array<int, PlantRubricInfoWithoutRubricIdReqDto> $infos
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public array $infos
    ) {}
}