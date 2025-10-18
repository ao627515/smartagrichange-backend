<?php

namespace App\DTO\Data;

use Spatie\LaravelData\Data;


class SensorData extends Data
{
    public function __construct(
        public float $temperature,
        public float $humidity,
        public float $ph,
        public float $ec,
        public float $n,
        public float $p,
        public float $k,
        public ?string $sensor_model = null
    ) {}
}