<?php

namespace App\DTO\Data;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PlantAnomalyData extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public string $causes,
        public string $solutions,
        public string $symptoms,
        public string $category,
        public string $preventions,
        #[Exists('plants', 'id')]
        public int $plant_id,
        public Optional|int $id,
        #[Exists('users', 'id')]
        public Optional|int|null $user_id
    ) {}
}
