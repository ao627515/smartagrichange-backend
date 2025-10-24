<?php

namespace App\Listeners;

use App\Events\PlantCreated;
use Illuminate\Support\Facades\Log;
use App\Services\PlantRubricService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePlantRubricsOnPlantCreated
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public PlantRubricService $plantRubricService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PlantCreated $event): void
    {
        $rubrics = $event->data['rubrics'] ?? [];

        if (!is_array($rubrics) || empty($rubrics)) {
            Log::warning('Aucune rubrique trouvée pour la plante créée', [
                'plant_id' => $event->plantId,
                'data' => $event->data,
            ]);
            return;
        }

        foreach ($rubrics as $rubric) {
            if (!is_array($rubric) || !isset($rubric['name'], $rubric['infos'])) {
                Log::error('Rubrique invalide ignorée lors de la création', [
                    'plant_id' => $event->plantId,
                    'rubric' => $rubric,
                ]);
                continue;
            }

            $rubricData = [
                ...$rubric,
                'plant_id' => $event->plantId,
            ];

            $this->plantRubricService->create($rubricData);
        }
    }
}
