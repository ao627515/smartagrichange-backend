<?php
// config/crop_recommandation.php
return [
    'api_endpoint' => env('CROP_RECOMMANDATION_API_ENDPOINT', 'https://api.crop-recommendation.example.com'),
    'api_key' => env('CROP_RECOMMANDATION_API_KEY', ''),
    'timeout' => env('CROP_RECOMMANDATION_TIMEOUT', 5),
    'retries' => env('CROP_RECOMMANDATION_RETRIES', 3)
];
