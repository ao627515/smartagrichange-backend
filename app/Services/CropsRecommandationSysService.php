<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CropsRecommandationSysService
{
    private string $apiEndpoint;
    private string $apiKey;
    public function __construct()
    {
        $this->apiEndpoint = config('crop_recommandation.api_endpoint');
        $this->apiKey = config('crop_recommandation.api_key');
    }

    public function getRecommendations(array $data): array
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])
            ->throw()
            ->post($this->apiEndpoint . '/crop-recommandation/predict/top', $data);

        if ($response->successful()) {
            return $response->json() ?? [];
        }

        return [];
    }
}
