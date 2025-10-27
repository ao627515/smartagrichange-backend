<?php

namespace App\DTO\Responses;

use App\Models\Analysis;
use App\Models\SoilAnalysis;
use Dflydev\DotAccessData\Data;
use App\DTO\Responses\SoilAnalysisResponse;
use Spatie\LaravelData\Data as LaravelDataData;
use App\DTO\Responses\SoilAnalysisSummaryResponse;
use App\DTO\Responses\AnomalyAnalysisMultiFilesSummaryResponse;

class AnalysisResponse extends LaravelDataData
{
    public string $type;
    public function __construct(
        public int $id,
        public string $analyzable_type,
        public int $analyzable_id,
        public int $user_id,
        public string $created_at,
        public SoilAnalysisSummaryResponse|AnomalyAnalysisMultiFilesSummaryResponse $analyzable,
        public ?int $parcel_id = null
    ) {
        $this->type = $this->analyzable_type == SoilAnalysis::class ? 'soil_analysis' : 'anomaly_detection_analysis';
    }

    public static function fromModel(Analysis $model)
    {
        $model->load('analyzable');
        return new self(
            id: $model->id,
            analyzable_type: $model->analyzable_type,
            analyzable_id: $model->analyzable_id,
            user_id: $model->user_id,
            parcel_id: $model->parcel_id,
            created_at: $model->created_at?->toDateTimeString(),
            analyzable: (get_class($model->analyzable) == SoilAnalysis::class
                ? SoilAnalysisSummaryResponse::from($model->analyzable)
                : AnomalyAnalysisMultiFilesSummaryResponse::from($model->analyzable)),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'parcel_id' => $this->parcel_id,
            'created_at' => $this->created_at,
            'analyzable' => $this->analyzable?->toArray(),
        ];
    }
}
