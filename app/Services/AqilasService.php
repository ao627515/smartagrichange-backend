<?php

namespace App\Services;

use App\DTO\Requests\Aquilas\AquilasSendSmsRequestDto;
use App\DTO\Responses\Aquilas\AquilasCreditResponseDto;
use App\DTO\Responses\Aquilas\AquilasSendSmsSuccessResponseDto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\DTO\Responses\Aquilas\AquilasSmsStatusResponseDto;

class AqilasService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('aqilas.base_url');
        $this->apiKey = config('aqilas.api_key');
    }

    /**
     * Envoyer un SMS via l'API AQILAS
     *
     * @param string $to     Numéro du destinataire (ex: +226XXXXXXXX)
     * @param string $message Contenu du SMS
     * @return AquilasSendSmsSuccessResponseDto|null
     */
    public function sendSms(AquilasSendSmsRequestDto $data)
    {
        $response = Http::withHeaders([
            'X-AUTH-TOKEN' => $this->apiKey,
            'Accept'       => 'application/json',
        ])->post($this->baseUrl . 'sms', $data->toArray());

        if ($response->successful()) {
            return new AquilasSendSmsSuccessResponseDto(
                success: $response->json('success'),
                message: $response->json('message'),
                bulk_id: $response->json('bulk_id'),
                cost: $response->json('cost'),
                currency: $response->json('currency')
            );
        }

        // Ici tu peux logger ou gérer les erreurs comme tu veux
        Log::error('AQILAS SMS failed', $data->toArray());

        return null;
    }

    public function getCredits()
    {
        $response = Http::withHeaders([
            'X-AUTH-TOKEN' => $this->apiKey,
            'Accept'       => 'application/json',
        ])->get($this->baseUrl . 'credits');

        if ($response->successful()) {
            return new AquilasCreditResponseDto(
                success: $response->json('success'),
                credits: $response->json('credits'),
                currency: $response->json('currency')
            );
        }

        // Ici tu peux logger ou gérer les erreurs comme tu veux
        Log::error('AQILAS Get Credits failed', [
            'response' => $response->body(),
        ]);

        return null;
    }

    public function getSmsStatus(string $smsId)
    {
        $response = Http::withHeaders([
            'X-AUTH-TOKEN' => $this->apiKey,
            'Accept'       => 'application/json',
        ])->get($this->baseUrl . 'sms/' . $smsId);

        if ($response->successful()) {
            return new AquilasSmsStatusResponseDto(
                id: $response->json('id'),
                to: $response->json('to'),
                updated_at: $response->json('updated_at'),
                sent_at: $response->json('sent_at'),
                status: $response->json('status'),
            );
        }

        // Ici tu peux logger ou gérer les erreurs comme tu veux
        Log::error('AQILAS Get SMS Status failed', [
            'smsId' => $smsId,
            'response' => $response->body(),
        ]);

        return null;
    }
}
