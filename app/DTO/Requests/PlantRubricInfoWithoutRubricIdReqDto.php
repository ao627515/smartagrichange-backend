<?php

namespace App\DTO\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class PlantRubricInfoWithoutRubricIdReqDto extends Data
{
    public function __construct(
        public string $key,
        public string $value,
    ) {}
}
