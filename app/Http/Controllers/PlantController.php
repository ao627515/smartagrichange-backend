<?php

namespace App\Http\Controllers;

use App\DTO\Data\PlantAnomalyData;
use App\Models\Plant;
use Illuminate\Http\Request;
use App\Services\PlantService;
use App\DTO\Req\PlantRequestDto;
use App\DTO\Req\UpdatePlantRequestDto;
use App\DTO\Responses\PlantResponseDto;
use App\Http\Resources\SuccessResponseResource;

class PlantController extends Controller
{
    public function __construct(
        private readonly PlantService $plantService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $plants = $this->plantService->allOrdered();

            $plantDtos = array_map(function ($plant) {
                return PlantResponseDto::fromModel($plant);
            }, $plants->all());

            return new SuccessResponseResource(message: 'Plants retrieved successfully', data: $plantDtos);
        });
    }
    public function indexWithRubrics()
    {
        return $this->handleRequestException(function () {
            $plants = $this->plantService->latestWithRelations(['rubrics.infos']);

            $plantDtos = PlantResponseDto::collect($plants);

            return new SuccessResponseResource(message: 'Plants retrieved successfully', data: $plantDtos);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = PlantRequestDto::validateAndCreate($request->all())->toArray();
            $plant = $this->plantService->create($data);

            return new SuccessResponseResource(message: 'Plant created successfully', data: PlantResponseDto::fromModel($plant));
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $plant)
    {
        return $this->handleRequestException(function () use ($plant) {
            $plantModel = $this->plantService->findOrFail($plant);

            return new SuccessResponseResource(message: 'Plant retrieved successfully', data: PlantResponseDto::fromModel($plantModel));
        });
    }

    public function showWithRubrics(string $plant)
    {
        return $this->handleRequestException(function () use ($plant) {
            $plantModel = $this->plantService->findOrFailWithRubrics($plant);

            return new SuccessResponseResource(message: 'Plant retrieved successfully', data: PlantResponseDto::fromModel($plantModel));
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $plant)
    {
        return $this->handleRequestException(function () use ($request, $plant) {
            $data = UpdatePlantRequestDto::validateAndCreate($request->all())->toArray();
            $updatedPlant = $this->plantService->update($plant, $data);

            return new SuccessResponseResource(message: 'Plant updated successfully', data: PlantResponseDto::fromModel($updatedPlant));
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $plant)
    {
        return $this->handleRequestException(function () use ($plant) {
            $this->plantService->delete($plant);

            return new SuccessResponseResource(message: 'Plant deleted successfully');
        });
    }

    public function anomalies(int $plant)
    {
        return $this->handleRequestException(function () use ($plant) {
            $data = $this->plantService->anomalies($plant);

            return new SuccessResponseResource(message: 'Plant anomalies retrieved successfully', data: PlantAnomalyData::collect($data));
        });
    }
}
