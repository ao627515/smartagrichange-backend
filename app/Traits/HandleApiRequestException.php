<?php

namespace App\Traits;

use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\SuccessResponseResource;
use Exception;
use Illuminate\Support\Facades\Log;

trait HandleApiRequestException
{
    public function handleRequestException($callable): SuccessResponseResource|ErrorResponseResource
    {
        try {
            return $callable();
        } catch (Exception $e) {
            // Log the exception or handle it as needed
            Log::error('handleRequestException: ' . $e->getMessage());

            return new ErrorResponseResource('An error occurred while processing your request.', $e->getMessage());
        }
    }
}
