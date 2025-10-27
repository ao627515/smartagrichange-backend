<?php

namespace App\DTO\Data;

use Spatie\LaravelData\Data;


class ClassifierPrediction extends Data
{
    public function __construct(
        public string $class_name,
        public float $confidence
    ) {}
}
