<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\SuccessResponseResource;

trait HandleApiRequestException
{
    public function handleRequestException($callable): SuccessResponseResource|ErrorResponseResource
    {
        try {
            return DB::transaction(fn() => $callable());
        } catch (Exception $e) {
            // Log the exception or handle it as needed
            Log::error('handleRequestException: ' . $e->getMessage());

            return new ErrorResponseResource('An error occurred while processing your request.', $e->getMessage());
        }
    }
}
