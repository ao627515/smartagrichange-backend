<?php

namespace App\Enums;

use App\Enums\Traits\EnumHelpersTrait;

enum UserRoleEnum: string
{
    use EnumHelpersTrait;
    case ADMIN = 'admin';
    case FARMER = 'farmer';

    public static function default(): ?UserRoleEnum
    {
        return self::FARMER;
    }

    public static function labels(): array
    {
        return [
            self::ADMIN->value => __('administrator'),
            self::FARMER->value => __('farmer'),
        ];
    }
}
