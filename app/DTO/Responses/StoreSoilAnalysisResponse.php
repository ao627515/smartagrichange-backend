<?php

namespace App\DTO\Responses;

use App\DTO\Data\CropRecommandedData;
use App\DTO\Data\SensorData;
use App\Models\SoilAnalysis;
use Spatie\LaravelData\Data;

class StoreSoilAnalysisResponse extends Data
{
    /**
     * Summary of __construct
     * @param int $id
     * @param SensorData $sensor_data
     * @param array<int, CropRecommandedData> $crops_recommanded
     * @param string $description
     * @param string $sensor_model
     * @param int $user_id
     * @param ?int $parcel_id
     */
    public function __construct(
        public int $id,
        public SensorData $sensor_data,
        public array $crops_recommanded,
        public ?string $description = null,
        public string $sensor_model,
        public int $user_id,
        public ?int $parcel_id = null,

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
            user_id: $model->analysis->user_id,
            parcel_id: $model->analysis->parcel_id,
        );
    }
}
