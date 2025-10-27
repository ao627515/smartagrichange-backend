<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnomalyDetectionAnalysis;
use App\Services\AnomalyAnalysisService;
use App\DTO\Req\AnomalyAnalysisImageRequest;
use App\DTO\Req\AnomalyAnalysisImagesRequest;
use App\Http\Resources\SuccessResponseResource;
use App\DTO\Responses\AnomalyAnalysisMultiFilesResponse;
use App\DTO\Responses\AnomalyAnalysisSingleFileResponse;

class AnomalyDetectionAnalysisController extends Controller
{
    public function __construct(
        public AnomalyAnalysisService $anomalyAnalysisService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleRequestException(function () {
            $res = $this->anomalyAnalysisService->allOrdered('created_at', 'desc');
            return new SuccessResponseResource(
                message: 'Anomaly analyses retrieved successfully.',
                data: AnomalyAnalysisMultiFilesResponse::collect($res)
            );
        });
    }

    /**
     * Store a newly created resource with a single image.
     */
    public function createwithSingleImg(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = AnomalyAnalysisImageRequest::validateAndCreate($request->all())->toArray();
            $res = $this->anomalyAnalysisService->createwithSingleImg($data);

            return new SuccessResponseResource(
                message: 'Anomaly analysis with single image created successfully.',
                data: AnomalyAnalysisMultiFilesResponse::from($res)
            );
        });
    }

    /**
     * Store a newly created resource with multiple images.
     */
    public function createwithMultiImgs(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = AnomalyAnalysisImagesRequest::validateAndCreate($request->all())->toArray();
            $res = $this->anomalyAnalysisService->createwithMultiImgs($data);

            return new SuccessResponseResource(
                message: 'Anomaly analysis with multiple images created successfully.',
                data: AnomalyAnalysisMultiFilesResponse::from($res)
            );
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->handleRequestException(function () use ($id) {
            $model = $this->anomalyAnalysisService->findOrFail($id);
            return new SuccessResponseResource(
                message: 'Anomaly analysis retrieved successfully.',
                data: AnomalyAnalysisMultiFilesResponse::from($model)
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->handleRequestException(function () use ($id) {
            $this->anomalyAnalysisService->delete($id);
            return new SuccessResponseResource(
                message: 'Anomaly analysis deleted successfully.'
            );
        });
    }
}
