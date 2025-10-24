<?php

namespace App\DTO\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class PlantRubricInfoReqDto extends Data
{
    public function __construct(
        public string $key,
        public string $value,
        public int $rubric_id
    ) {}
}
