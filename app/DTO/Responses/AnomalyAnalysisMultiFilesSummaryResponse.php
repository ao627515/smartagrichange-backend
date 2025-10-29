<?php

namespace App\DTO\Responses;

use App\DTO\Data\ClassifierPrediction;
use App\Models\AnomalyDetectionAnalysis;
use Spatie\LaravelData\Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnomalyAnalysisMultiFilesSummaryResponse extends Data
{
    /**
     * Summary of image
     * @var string[] $images
     */
    public array $images;
    public ?PlantAnomalyResponse $anomaly = null;

    public function __construct(
        public int $id,
        public string|ClassifierPrediction $model_result,
    ) {}

    public static function fromModel(AnomalyDetectionAnalysis $model)
    {
        $model->load('analysis', 'anomaly');
        $m = new self(
            $model->id,
            ClassifierPrediction::from($model->model_result),
        );

        $m->images = $model->getMedia('anomaly_analysis')->map(fn($media) => $media->getFullUrl())->toArray();

        if ($model->anomaly !== null) {
            $m->anomaly = PlantAnomalyResponse::fromModel($model->anomaly);
        }

        return $m;
    }
}
