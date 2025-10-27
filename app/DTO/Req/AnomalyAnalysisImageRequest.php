<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AnomalyAnalysisImageRequest extends Data
{

    /**
     * Summary of __construct
     * @param \Illuminate\Http\UploadedFile $image
     * @param ?int $parcel_id
     */
    public function __construct(
        public UploadedFile $image,
        #[Exists('parcels', 'id')]
        public ?int $parcel_id = null
    ) {}

    public static function rules(?ValidationContext $context = null)
    {
        return [
            'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }
}
