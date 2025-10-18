<?php

namespace App\Services;

use App\DTO\Data\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\SoilAnalysisCreated;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SoilAnalysisRepository;
use App\DTO\Responses\StoreSoilAnalysisResponse;

class SoilAnalysisService extends BaseService
{
    /**
     * Summary of repository
     * @var SoilAnalysisRepository
     */
    protected $repository;

    public function __construct(SoilAnalysisRepository $repository)
    {
        parent::__construct($repository);

        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Crée l'objet SensorData
            $sensorData = SensorData::from($data);

            // Prépare les données pour la création
            $data = array_merge($data, [
                'user_id' => Auth::id(),
                'sensor_data' => json_encode($sensorData),
            ]);

            // Crée l'enregistrement avec la relation analysis
            $record = $this->repository->createWithAnalysis($data);

            // Émet l'événement après création
            event(new SoilAnalysisCreated($record->id, ['sensor_data' => $sensorData]));

            // Recharge le modèle avec la relation analysis
            return $record->fresh();
        });
    }
}
