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
     * Create the event listener.
     */
    public function __construct(
        public AnomalyAnalysisService $anomalyAnalysisService,
        public AnomalyDetectionSysService $anomalyDetectionSysService,
        public PlantService $plantService,
        public PlantAnomalyService $plantAnomalyService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnomalyAnalysisCreated $event): void
    {
        $anomalyAnalysis =  $this->anomalyAnalysisService->findOrFail($event->anomalyAnalysisId);


        $data = $event->params;
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            // $img_path = $media->getUrl();
            // $img_path = "{$media->conversions_disk}/{$media->name}";
            $req = ['image' => $data['img']];
            $res = $this->anomalyDetectionSysService->predictWithFile($req);
            $this->anomalyAnalysisService->update($anomalyAnalysis->id, ['model_result' => $res->toJson()]);
            $anomalyAnalysis->addMedia($data['img'])->toMediaCollection('anomaly_analysis');
        }

        if (isset($data['imgs']) && is_array($data['imgs'])) {
            $req = ['images' => $data['imgs']];
            // appler l'api pour la prediction un tab avec la liste des proba
            $res = $this->anomalyDetectionSysService->predictMultipleFiles($req);
            // save les donnees envoyer par l'ia
            $this->anomalyAnalysisService->update($anomalyAnalysis->id, ['model_result' => $res->toJson()]);

            // save les image utilise pour la prediction
            foreach ($data['imgs'] as $file) {
                $anomalyAnalysis->addMedia($file)->toMediaCollection('anomaly_analysis');
            }

            // identifier la plante et l'anommalie
            // la revoyer par le model est au format {plant}___{anomaly}
            $tmp = explode('___', $res->class_name);
            $plantName = Str::of($tmp[0])->lower()->toString();
            $anomalyName = Str::of($tmp[1])->replace('_', ' ')->lower()->toString();

            $plant = $this->plantService->findOrFailByCommonName(__($plantName), ['id']);
            $anomaly = $this->plantAnomalyService->findOrFailByNameAndPlant($plant->id, __($anomalyName), ['id']);
            $this->anomalyAnalysisService->update($anomalyAnalysis->id, ['plant_id' => $plant->id, 'anomaly_id' => $anomaly->id]);
        }
    }
}
