<?php

namespace App\DTO\Req;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Exists;

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
}
