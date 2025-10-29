<?php

namespace App\Services;

use App\DTO\Data\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\SoilAnalysisCreated;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SoilAnalysisRepository;
use App\DTO\Responses\SoilAnalysisResponse;
use App\Models\SoilAnalysis;

class SoilAnalysisService extends BaseService
{
    /**
     * Summary of repository
     * @var SoilAnalysisRepository
     */
    protected $repository;

    /**
     * Profondeur de sol par défaut en cm
     */
    private const DEFAULT_SOIL_DEPTH = 20;

    /**
     * Densité apparente par défaut en g/cm³
     */
    private const DEFAULT_BULK_DENSITY = 1.4;

    public function __construct(
        SoilAnalysisRepository $repository,
        private UserService $userService
    ) {
        parent::__construct($repository);

        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Crée l'objet SensorData
            $sensorData = SensorData::from($data);

            // Convertit les valeurs NPK
            // $sensorData = SensorData::from(array_merge($sensorData->toArray(), $this->convertNPKToKgPerHa($sensorData)));

            // Prépare les données pour la création
            $data = array_merge($data, [
                'user_id' => Auth::id(),
                'sensor_data' => json_encode($sensorData),
            ]);

            // Crée l'enregistrement avec la relation analysis
            $record = $this->repository->createWithAnalysis($data);

            // Émet l'événement après création
            event(new SoilAnalysisCreated($record->id, [
                'sensor_data' => $sensorData,
            ]));

            // Recharge le modèle avec la relation analysis
            return $record->fresh();
        });
    }

    /**
     * Convertit les valeurs NPK de mg/kg vers kg/ha
     *
     * @param SensorData $sensorData
     * @param float|null $soilDepth Profondeur du sol en cm (défaut: 20 cm)
     * @param float|null $bulkDensity Densité apparente en g/cm³ (défaut: 1.4)
     * @return array
     */
    private function convertNPKToKgPerHa(
        SensorData $sensorData,
        ?float $soilDepth = null,
        ?float $bulkDensity = null
    ): array {
        $depth = $soilDepth ?? self::DEFAULT_SOIL_DEPTH;
        $density = $bulkDensity ?? self::DEFAULT_BULK_DENSITY;

        // Facteur de conversion : profondeur × densité × 10
        $conversionFactor = $depth * $density * 10;

        return [
            'n' => round($sensorData->n * $conversionFactor, 2),
            'p' => round($sensorData->p * $conversionFactor, 2),
            'k' => round($sensorData->k * $conversionFactor, 2),
        ];
    }

    public function findOrFailWithAnalysis($id, $columns = ['*']): SoilAnalysis
    {
        return $this->repository->findOrFail($id, $columns)->load('analysis');
    }

    public function allOrderedWithRelations($orderBy = 'id', $direction = 'asc', $columns = ['*'], $relations = [])
    {
        return $this->repository->allOrderedWithRelations($orderBy, $direction, $columns, $relations);
    }

    public function userAnalysesLatest($userId, $columns = ['*'])
    {
        $this->userService->findOrFail($userId);
        return $this->repository->userAnalysesLatest($userId, $columns);
    }
}
