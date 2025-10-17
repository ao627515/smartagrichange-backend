<?php

namespace App\DTO\Requests;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class FarmerProfileRequestDto extends Data
{

    public function __construct(
        public string $firstname,
        public string $lastname,
        public string $phone_number,
        #[Exists('country_calling_codes', 'calling_code')]
        public string $calling_code,
        public ?string $email = null,
    ) {}
}
