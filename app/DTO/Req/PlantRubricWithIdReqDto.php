<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Exists;

class PlantRubricWithIdReqDto extends Data
{
    /**
     * Summary of __construct
     * @param string $name
     * @param ?string $description
     * @param int $id
     * @param array<int, PlantRubricInfoWithIdReqDto> $infos
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public array $infos
    ) {}
}
