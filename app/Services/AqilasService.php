<?php

namespace App\Services;

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
     * En-têtes communs pour toutes les requêtes AQILAS
     */
    protected function headers(): array
    {
        return [
            'X-AUTH-TOKEN' => $this->apiKey,
            'Accept'       => 'application/json',
        ];
    }

    /**
     * Méthode générique pour envoyer les requêtes HTTP
     */
    protected function sendRequest(string $method, string $endpoint, array $data = []): ?array
    {
        try {
            $response = match (strtoupper($method)) {
                'GET' => Http::withHeaders($this->headers())->get($this->baseUrl . $endpoint, $data),
                'POST' => Http::withHeaders($this->headers())->post($this->baseUrl . $endpoint, $data),
                default => throw new \InvalidArgumentException("HTTP method $method not supported."),
            };

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("AQILAS request failed", [
                'method'   => $method,
                'endpoint' => $endpoint,
                'data'     => $data,
                'response' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error("AQILAS request exception: " . $e->getMessage(), [
                'method'   => $method,
                'endpoint' => $endpoint,
                'data'     => $data,
            ]);
        }

        return null;
    }

    /**
     * Envoyer un SMS
     */
    public function sendSms(string $to, string $message): ?AquilasSendSmsSuccessResponseDto
    {
        $json = $this->sendRequest('POST', 'sms', ['to' => $to, 'message' => $message]);

        return $json ? new AquilasSendSmsSuccessResponseDto(
            success: $json['success'] ?? false,
            message: $json['message'] ?? null,
            bulk_id: $json['bulk_id'] ?? null,
            cost: $json['cost'] ?? null,
            currency: $json['currency'] ?? null
        ) : null;
    }

    /**
     * Obtenir le solde de crédits
     */
    public function getCredits(): ?AquilasCreditResponseDto
    {
        $json = $this->sendRequest('GET', 'credits');

        return $json ? new AquilasCreditResponseDto(
            success: $json['success'] ?? false,
            credits: $json['credits'] ?? 0,
            currency: $json['currency'] ?? null
        ) : null;
    }

    /**
     * Obtenir le statut d’un SMS
     */
    public function getSmsStatus(string $smsId): ?AquilasSmsStatusResponseDto
    {
        $json = $this->sendRequest('GET', 'sms/' . $smsId);

        return $json ? new AquilasSmsStatusResponseDto(
            id: $json['id'] ?? null,
            to: $json['to'] ?? null,
            updated_at: $json['updated_at'] ?? null,
            sent_at: $json['sent_at'] ?? null,
            status: $json['status'] ?? null,
        ) : null;
    }
}
