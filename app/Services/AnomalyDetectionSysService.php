<?php

namespace App\Services;

class AnomalyDetectionSysService
{
    private string $apiEndpoint;

    public function __construct()
    {
        $this->apiEndpoint = config('anomaly_detector.api_url');
    }

    public function predictWithFile() {}

    public function predictMultipleFiles() {}
}
