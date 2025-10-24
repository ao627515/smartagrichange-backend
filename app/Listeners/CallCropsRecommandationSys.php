<?php

namespace App\Listeners;

use App\DTO\Req\CropPredictionProbabilitiesRequest;
use App\Events\SoilAnalysisCreated;
use App\Services\CropsRecommandationSysService;
use App\Services\SoilAnalysisService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CallCropsRecommandationSys
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private CropsRecommandationSysService $cropsRecommandationSysService,
        private SoilAnalysisService $soilAnalysisService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SoilAnalysisCreated $event): void
    {
        $this->soilAnalysisService->findOrFail($event->soilAnalysisId);

        $dto =  CropPredictionProbabilitiesRequest::from($event->data['sensor_data'] ?? []);
        $res =    $this->cropsRecommandationSysService->getRecommendations(
            $dto->toArray()
        );

        $this->soilAnalysisService->update($event->soilAnalysisId, [
            'crops_recommanded' => json_encode($res)
        ]);
    }
}
