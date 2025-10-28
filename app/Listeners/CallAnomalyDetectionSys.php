<?php

namespace App\Listeners;

use App\Events\AnomalyAnalysisCreated;
use App\Models\Plant;
use App\Services\AnomalyAnalysisService;
use App\Services\AnomalyDetectionSysService;
use App\Services\PlantAnomalyService;
use App\Services\PlantService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CallAnomalyDetectionSys
{
    /**
     * Constructeur avec injection des services nécessaires.
     */
    public function __construct(
        public AnomalyAnalysisService $anomalyAnalysisService,
        public AnomalyDetectionSysService $anomalyDetectionSysService,
        public PlantService $plantService,
        public PlantAnomalyService $plantAnomalyService
    ) {}

    /**
     * Handle l'événement de création d'une analyse d'anomalie.
     */
    public function handle(AnomalyAnalysisCreated $event): void
    {
        // Récupération de l'analyse via son ID
        $anomalyAnalysis = $this->anomalyAnalysisService->findOrFail($event->anomalyAnalysisId);
        $data = $event->params;

        // --- Traitement d'une image unique ---
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            $res = $this->anomalyDetectionSysService->predictWithFile(['image' => $data['img']]);
            $this->anomalyAnalysisService->update($anomalyAnalysis->id, ['model_result' => $res->toJson()]);
            $anomalyAnalysis->addMedia($data['img'])->toMediaCollection('anomaly_analysis');
        }

        // --- Traitement de plusieurs images ---
        if (isset($data['imgs']) && is_array($data['imgs'])) {
            $res = $this->anomalyDetectionSysService->predictMultipleFiles(['images' => $data['imgs']]);
            $this->anomalyAnalysisService->update($anomalyAnalysis->id, ['model_result' => $res->toJson()]);

            foreach ($data['imgs'] as $file) {
                $anomalyAnalysis->addMedia($file)->toMediaCollection('anomaly_analysis');
            }
        }

        // --- Identifier la plante et l'anomalie depuis la classe renvoyée par le modèle ---
        [$plantNameRaw, $anomalyNameRaw] = explode('___', $res->class_name);
        $plantName = Str::of($plantNameRaw)->lower()->toString();
        $anomalyName = Str::of($anomalyNameRaw)->replace('_', ' ')->lower()->toString();

        $plant = $this->plantService->findOrFailByCommonName(__($plantName), ['id']);
        $anomaly = $this->plantAnomalyService->findOrFailByNameAndPlant($plant->id, __($anomalyName), ['id']);

        // --- Mise à jour des IDs de la plante et de l'anomalie dans l'analyse ---
        $this->anomalyAnalysisService->update($anomalyAnalysis->id, [
            'plant_id' => $plant->id,
            'anomaly_id' => $anomaly->id
        ]);
    }
}
