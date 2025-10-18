<?php

namespace App\DTO\Data;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class ChangePasswordData extends Data
{
    public function __construct(
        public string $current_password,
        #[Min(8), Confirmed]
        public string $new_password,
        // public string $new_password_confirmation,
    ) {}
}
