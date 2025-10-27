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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createwithSingleImg(Request $request)
    {
        return $this->handleRequestException(function () use ($request) {
            $data = AnomalyAnalysisImageRequest::validateAndCreate($request->all())->toArray();
            $res = $this->anomalyAnalysisService->createwithSingleImg($data);
            // $res = null;
            return new SuccessResponseResource(
                message: 'Soil analysis created successfully',
                data: AnomalyAnalysisMultiFilesResponse::from($res)
            );
        });
    }

    public function createwithMultiImgs(Request $request)
    {

        return $this->handleRequestException(function () use ($request) {
            $data = AnomalyAnalysisImagesRequest::validateAndCreate($request->all())->toArray();
            $res = $this->anomalyAnalysisService->createwithMultiImgs($data);
            // $res = null;
            return new SuccessResponseResource(
                message: 'Soil analysis created successfully',
                data: AnomalyAnalysisMultiFilesResponse::from($res)
            );
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
