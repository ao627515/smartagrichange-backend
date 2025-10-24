<?php

namespace App\Listeners;

use App\Events\PlantRubricCreated;
use Illuminate\Support\Facades\Log;
use App\Services\PlantRubricInfoService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePlantRubricsInfoOnPlantRubricCreated
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
    public function handle(PlantRubricCreated $event): void
    {
        $infos = $event->data['infos'] ?? [];

        if (!is_array($infos) || empty($infos)) {
            Log::info('Aucune info à créer pour la rubrique', [
                'rubric_id' => $event->rubricId,
            ]);
            return;
        }

        foreach ($infos as $info) {
            if (!is_array($info) || !isset($info['key'], $info['value'])) {
                Log::warning('Info invalide ignorée', [
                    'rubric_id' => $event->rubricId,
                    'info' => $info,
                ]);
                continue;
            }

            $rubricInfoData = [
                ...$info,
                'rubric_id' => $event->rubricId, // correction clé étrangère
            ];

            $this->plantRubricInfoService->create($rubricInfoData);
        }
    }
}
