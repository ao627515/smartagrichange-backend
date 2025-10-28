<?php

namespace App\DTO\Responses;

use App\DTO\Data\ClassifierPrediction;
use App\Models\Anomaly;
use App\Models\AnomalyDetectionAnalysis;
use App\Models\Plant;
use Spatie\LaravelData\Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnomalyAnalysisMultiFilesResponse extends Data
{
    /**
     * Summary of image
     * @var string[] $images
     */
    public array $images;
    public Plant $plant;
    public Anomaly $anomaly;

    public function __construct(
        public int $id,
        public string|ClassifierPrediction $model_result,
        public $created_at,
        public int $user_id,
        public  ?int $parcel_id
    ) {}

    public static function fromModel(AnomalyDetectionAnalysis $model)
    {
        $model->load(['analysis', 'plant.rubrics.infos', 'anomaly']);
        $m = new self(
            $model->id,
            ClassifierPrediction::from($model->model_result),
            $model->created_at,
            $model->analysis->user_id,
            $model->analysis->parcel_id,
        );

        $m->images = $model->getMedia('anomaly_analysis')->map(fn($media) => $media->getFullUrl())->toArray();

        $m->plant = $model->plant;
        $m->anomaly = $model->anomaly;

        return $m;
    }
}
