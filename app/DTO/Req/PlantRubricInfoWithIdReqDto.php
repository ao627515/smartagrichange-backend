<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Exists;

class PlantRubricInfoWithIdReqDto extends Data
{
    public function __construct(
        public string $key,
        public string $value,
    ) {}
}
