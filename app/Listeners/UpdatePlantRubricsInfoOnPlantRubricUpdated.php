<?php

namespace App\Listeners;

use App\Events\PlantRubricUpdated;
use Illuminate\Support\Facades\Log;
use App\Services\PlantRubricService;
use App\Services\PlantRubricInfoService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePlantRubricsInfoOnPlantRubricUpdated
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public PlantRubricInfoService $plantRubricInfoService

    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PlantRubricUpdated $event): void
    {
        $infos = $event->data['infos'] ?? [];

        if (!is_array($infos) || empty($infos)) {
            Log::info('Aucune info à mettre à jour pour la rubrique', [
                'rubric_id' => $event->rubricId,
            ]);
            return;
        }

        foreach ($infos as $info) {
            if (!is_array($info) || !isset($info['id'], $info['key'], $info['value'])) {
                Log::warning('Info invalide ignorée lors de la mise à jour', [
                    'rubric_id' => $event->rubricId,
                    'info' => $info,
                ]);
                continue;
            }

            // Mise à jour via le service
            $this->plantRubricInfoService->update($info['id'], $info);
        }
    }
}
