<?php

namespace App\DTO\Responses;

use App\DTO\Data\SensorData;
use App\Models\SoilAnalysis;
use Spatie\LaravelData\Data;
use App\DTO\Data\CropRecommandedData;

class SoilAnalysisSummaryResponse extends Data
{
    public function __construct(
        public int $id,
        public SensorData $sensor_data,
        public array $crops_recommanded,
        public ?string $description = null,
        public ?string $sensor_model = null,
    ) {}

    public static function fromModel(SoilAnalysis $model)
    {
        return new self(
            id: $model->id,
            sensor_data: SensorData::from(json_decode($model->sensor_data, true)),
            crops_recommanded: array_map(
                fn($item) => CropRecommandedData::from((array) $item),
                json_decode($model->crops_recommanded ?? '[]', true)
            ),
            description: $model->description,
            sensor_model: $model->sensor_model,
        );
    }
}
