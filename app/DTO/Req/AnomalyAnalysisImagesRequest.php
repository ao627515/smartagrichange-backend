<?php

namespace App\DTO\Req;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class AnomalyAnalysisImagesRequest extends Data
{
    /**
     * Summary of __construct
     * @param UploadedFile[] $imagess
     */
    public function __construct(
        public array $images
    ) {}
}
