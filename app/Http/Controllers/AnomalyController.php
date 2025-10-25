<?php

namespace App\Http\Controllers;

use App\Models\Anomaly;
use Illuminate\Http\Request;
use App\DTO\Data\PlantAnomalyData;
use App\Services\PlantAnomalyService;
use App\Http\Resources\SuccessResponseResource;

class AnomalyController extends Controller
{
    public function __construct(
        private PlantAnomalyService $anomalyService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $anomalies = $this->anomalyService->allOrdered('created_at', 'desc');
            return new SuccessResponseResource(
                'Anomalies retrieved successfully',
                PlantAnomalyData::collect($anomalies)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            // $t = $request->all();/
            $data = PlantAnomalyData::validateAndCreate($request->all())->toArray();
            $anomaly = $this->anomalyService->create($data);

            return new SuccessResponseResource(
                'Anomaly created successfully',
                PlantAnomalyData::from($anomaly)
            );
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($anomaly)
    {
        return $this->handleRequestException(function () use ($anomaly) {
            $anomaly = $this->anomalyService->findOrFail($anomaly);
            return new SuccessResponseResource(
                'Anomaly retrieved successfully',
                PlantAnomalyData::from($anomaly)
            );
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $anomaly)
    {
        return $this->handleRequestException(function () use ($request, $anomaly) {
            $data = PlantAnomalyData::validateAndCreate($request->all())->toArray();
            $updatedAnomaly = $this->anomalyService->update($anomaly, $data);

            return new SuccessResponseResource(
                'Anomaly updated successfully',
                PlantAnomalyData::from($updatedAnomaly)
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($anomaly)
    {
        return $this->handleRequestException(function () use ($anomaly) {
            $this->anomalyService->delete($anomaly);
            return new SuccessResponseResource('Anomaly deleted successfully');
        });
    }

    public function uploadImage(Request $req, int $anomaly)
    {
        return $this->handleRequestException(function () use ($req, $anomaly) {
            $data = $req->validate([
                'image' => ['required', 'image', 'max:2048'],
            ]);


            $media = $this->anomalyService->uploadImage($anomaly, $data['image']);

            return new SuccessResponseResource(
                data: $media,
                message: 'Anomaly image uploaded successfully'
            );
        });
    }

    public function uploadImages(Request $req, int $anomaly)
    {
        return $this->handleRequestException(function () use ($req, $anomaly) {
            $data = $req->validate([
                'images' => ['required', 'array'],
                'images.*' => ['image', 'max:2048'],
            ]);


            $mediaList = $this->anomalyService->uploadImages($anomaly, $data['images']);

            return new SuccessResponseResource(
                data: $mediaList,
                message: 'Anomaly images uploaded successfully'
            );
        });
    }
}
