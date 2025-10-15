<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Http\Request;
use App\Services\ParcelService;
use App\Http\Resources\Parcel\ParcelResource;
use App\Http\Resources\SuccessResponseResource;
use App\Http\Requests\Parcel\ParcelStoreRequest;
use App\Http\Requests\Parcel\ParcelUpdateRequest;

class ParcelController extends Controller
{
    public function __construct(
        private ParcelService $parcelService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $parcels = $this->parcelService->allOrdered('created_at', 'desc');
            return new SuccessResponseResource(
                'Parcels retrieved successfully',
                ParcelResource::collection($parcels)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParcelStoreRequest $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id; // Si applicable
            $parcel = $this->parcelService->create($data);

            return new SuccessResponseResource(
                'Parcel created successfully',
                new ParcelResource($parcel)
            );
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($parcel)
    {
        return $this->handleRequestException(function () use ($parcel) {
            $parcel = $this->parcelService->findOrFail($parcel);
            return new SuccessResponseResource(
                'Parcel retrieved successfully',
                new ParcelResource($parcel)
            );
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParcelUpdateRequest $request, $parcel)
    {
        return $this->handleRequestException(function () use ($request, $parcel) {
            $data = $request->validated();
            $updatedParcel = $this->parcelService->update($parcel, $data);

            return new SuccessResponseResource(
                'Parcel updated successfully',
                new ParcelResource($updatedParcel)
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($parcel)
    {
        return $this->handleRequestException(function () use ($parcel) {
            $this->parcelService->delete($parcel);
            return new SuccessResponseResource('Parcel deleted successfully');
        });
    }
}
