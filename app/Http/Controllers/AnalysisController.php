<?php

namespace App\Http\Controllers;

use App\DTO\Responses\AnalysisResponse;
use Illuminate\Http\Request;
use App\Services\AnalysisService;
use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\SuccessResponseResource;
use App\Http\Resources\Analysis\AnalysisResource;
use App\Http\Resources\Analysis\AnalysisCollection;

class AnalysisController extends Controller
{

    public function __construct(
        private AnalysisService $analysisService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $analyses = $this->analysisService->allLatestWithRelations(['analyzable']);
            $analysesArray = $analyses->toArray();
            return new SuccessResponseResource(
                'Analyses retrieved successfully.',
                AnalysisCollection::make(AnalysisResponse::collect($analyses))
            );
        });
    }

    public function userAnalyses($userId)
    {
        return $this->handleRequestException(function () use ($userId) {
            $analyses = $this->analysisService->getByUserWithRelations($userId, ['analyzable']);
            return new SuccessResponseResource(
                'User analyses retrieved successfully.',
                AnalysisCollection::make(AnalysisResponse::collect($analyses))

            );
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new ErrorResponseResource('Created analysis not supported.', null, 405);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $analysis)
    {
        return $this->handleRequestException(function () use ($analysis) {
            $analysisModel = $this->analysisService->findOrFail($analysis);
            return new SuccessResponseResource(
                'Analysis retrieved successfully.',
                new AnalysisResource(AnalysisResponse::fromModel($analysisModel))
            );
        });
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $analysis)
    {
        return $this->handleRequestException(function () use ($analysis) {
            $this->analysisService->delete($analysis);
            return new SuccessResponseResource(
                'Analysis deleted successfully.',
                null
            );
        });
    }
}