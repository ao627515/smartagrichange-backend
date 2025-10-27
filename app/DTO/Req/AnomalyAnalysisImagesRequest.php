<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AnomalyAnalysisImagesRequest extends Data
{
    /**
     * Summary of __construct
     * @param UploadedFile[] $imagess
     */
    public function __construct(
        #[Exists('parcels', 'id')]
        public ?int $parcel_id = null,
        public array $images
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'image.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }
}
