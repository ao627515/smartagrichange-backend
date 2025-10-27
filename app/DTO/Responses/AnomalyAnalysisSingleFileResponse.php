<?php

namespace App\DTO\Responses;

use App\DTO\Data\ClassifierPrediction;
use App\Models\AnomalyDetectionAnalysis;
use Spatie\LaravelData\Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnomalyAnalysisSingleFileResponse extends Data
{
    public string $image;

    public function __construct(
        public int $id,
        public string|ClassifierPrediction $model_result,
        public $created_at,
        public int $user_id,
        public  ?int $parcel_id
    ) {}

    public static function fromModel(AnomalyDetectionAnalysis $model)
    {
        $model->load('analysis');
        $m = new self(
            $model->id,
            ClassifierPrediction::from($model->model_result),
            $model->created_at,
            $model->analysis->user_id,
            $model->analysis->parcel_id,
        );

        $m->image = $model->getMedia('anomaly_analysis')[0]->getFullUrl();

        return $m;
    }
}
