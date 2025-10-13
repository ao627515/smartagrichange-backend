<?php

namespace App\Listeners;

use Exception;
use App\Events\FieldCreated;
use App\Services\FieldService;
use App\Services\ParcelService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateFieldParcel
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private ParcelService $parcelService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FieldCreated $event): void
    {
        $this->parcelService->createForField($event->fieldId);
    }
}
