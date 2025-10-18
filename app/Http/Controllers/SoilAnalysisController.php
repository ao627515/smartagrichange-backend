<?php

namespace App\Http\Controllers;

use App\DTO\Data\SensorData;
use App\Models\SoilAnalysis;
use Illuminate\Http\Request;
use App\DTO\Data\CropRecommandedData;
use App\Services\SoilAnalysisService;
use App\Http\Resources\SuccessResponseResource;
use App\DTO\Responses\StoreSoilAnalysisResponse;
use App\DTO\Requests\StoreSoilAnalysisRequestDto;

class SoilAnalysisController extends Controller
{

    public function __construct(private SoilAnalysisService $soilAnalysisService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $res = $this->soilAnalysisService->allOrderedWithRelations(relations: ['analysis']);
            return new SuccessResponseResource(
                message: 'Soil analyses retrieved successfully',
                data: array_map(
                    fn($item) => StoreSoilAnalysisResponse::fromModel($item),
                    $res->all()
                )
            );
        });
    }

    public function userAnalyses($user)
    {
        return $this->handleRequestException(function () use ($user) {
            $res = $this->soilAnalysisService->userAnalysesLatest($user);
            return new SuccessResponseResource(
                message: 'Soil analyses retrieved successfully',
                data: array_map(
                    fn($item) => StoreSoilAnalysisResponse::fromModel($item),
                    $res->all()
                )
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = StoreSoilAnalysisRequestDto::validateAndCreate($request->all())->toArray();
            $res = $this->soilAnalysisService->create($data);
            return new SuccessResponseResource(
                message: 'Soil analysis created successfully',
                data: StoreSoilAnalysisResponse::fromModel($res)
            );
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($soil_analysis)
    {
        return $this->handleRequestException(function () use ($soil_analysis) {
            $res = $this->soilAnalysisService->findOrFailWithAnalysis($soil_analysis);
            return new SuccessResponseResource(
                message: 'Soil analysis retrieved successfully',
                data: StoreSoilAnalysisResponse::fromModel($res)
            );
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SoilAnalysis $soilAnalysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($soil_analysis)
    {
        return $this->handleRequestException(function () use ($soil_analysis) {
            $this->soilAnalysisService->delete($soil_analysis);
            return new SuccessResponseResource(
                message: 'Soil analysis deleted successfully',
                data: null
            );
        });
    }
}
