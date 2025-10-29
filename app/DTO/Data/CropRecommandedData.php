<?php

namespace App\DTO\Data;

use Spatie\LaravelData\Data;

class CropRecommandedData extends Data
{
    public function __construct(
        public string $crop,
        public float $probability
    ) {
        $this->crop = __($crop);
    }
}
