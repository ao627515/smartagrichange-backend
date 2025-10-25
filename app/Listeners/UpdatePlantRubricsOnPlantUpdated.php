<?php

namespace App\Listeners;

use App\Events\PlantUpdated;
use App\Services\PlantService;
use Illuminate\Support\Facades\Log;
use App\Services\PlantRubricService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePlantRubricsOnPlantUpdated
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public PlantService $plantService

    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PlantUpdated $event): void
    {
        $rubrics = $event->data['rubrics'] ?? [];

        if (!is_array($rubrics) || empty($rubrics)) {
            Log::warning('Aucune rubrique trouvée pour la plante créée', [
                'plant_id' => $event->plantId,
                'data' => $event->data,
            ]);
            return;
        }

        $this->plantService->syncRubrics($event->plantId, $rubrics);
    }
}
