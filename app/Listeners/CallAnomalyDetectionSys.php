<?php

namespace App\Listeners;

use App\Events\AnomalyAnalysisCreated;
use App\Services\AnomalyAnalysisService;
use App\Services\AnomalyDetectionSysService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;

class CallAnomalyDetectionSys
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public AnomalyAnalysisService $anomalyAnalysisService,
        public AnomalyDetectionSysService $anomalyDetectionSysService
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
    }
}
