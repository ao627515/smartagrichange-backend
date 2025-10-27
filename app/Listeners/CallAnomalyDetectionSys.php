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
        $this->anomalyAnalysisService->findOrFail($event->anomalyAnalysisId);

        $data = $event->params;
        if (isset($data['img']) && $data['img'] instanceof UploadedFile){
            $req = ['image' => $data['img']];
            

        }

        if (isset($data['imgs']))
            $req =  Validator::make($data, [
                'imgs' => ['array'],
                'imgs.*' => ['image']
            ])->validated();

        // $res =
    }
}