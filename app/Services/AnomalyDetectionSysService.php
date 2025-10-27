<?php

namespace App\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use App\DTO\Data\ClassifierPrediction;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;

class AnomalyDetectionSysService
{
    private string $baserUrl;
    private string $uri = 'tomato-diseases';
    private string $endpoint = '';
    // private string $uri = 'tpp-diseases'

    public function __construct()
    {
        $this->baserUrl = config('anomaly_detector.api_url');
        $this->endpoint = "{$this->baserUrl}/{$this->uri}";
    }

    /**
     * Envoie une image au service d'IA pour obtenir une prédiction.
     *
     * @param  array{image: \Illuminate\Http\UploadedFile}  $data
     * @return ClassifierPrediction
     *
     * @throws RequestException
     * @throws Exception
     */
    public function predictWithFile(array $data): ClassifierPrediction
    {
        // Vérification de la présence du fichier
        if (!isset($data['image']) || !$data['image'] instanceof UploadedFile) {
            throw new InvalidArgumentException('Une image valide est requise pour la prédiction.');
        }

        // Envoi de la requête HTTP
        $response = Http::asMultipart()
            ->acceptJson()
            ->post("{$this->endpoint}/predict", [
                'image' => fopen($data['image']->getRealPath(), 'r'),
            ]);

        // Gestion des erreurs HTTP
        if ($response->failed()) {
            throw new Exception(
                sprintf(
                    'Erreur lors de la prédiction (%d): %s',
                    $response->status(),
                    $response->body()
                )
            );
        }

        // Conversion en DTO typé
        return ClassifierPrediction::from($response->json());
    }


    /**
     * Summary of predictMultipleFiles
     * @param array{images:UploadedFile[]} $data
     * @throws InvalidArgumentException
     * @throws Exception
     * @return ClassifierPrediction
     */
    public function predictMultipleFiles(array $data): ClassifierPrediction
    {
        // Vérification des fichiers
        if (!isset($data['images']) || !is_array($data['images'])) {
            throw new InvalidArgumentException('Un tableau de fichiers est requis.');
        }

        $multipart = [];

        foreach ($data['images'] as $file) {
            if (!$file instanceof UploadedFile) {
                throw new InvalidArgumentException('Chaque élément doit être un UploadedFile.');
            }

            $multipart[] = [
                'name'     => 'images', // clé répétée pour chaque fichier
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        // Envoi de la requête HTTP
        $response = Http::asMultipart()
            ->acceptJson()
            ->post("{$this->endpoint}/predict/multi", $multipart);

        // Gestion des erreurs
        if ($response->failed()) {
            throw new Exception(sprintf(
                'Erreur lors de la prédiction (%d): %s',
                $response->status(),
                $response->body()
            ));
        }

        return ClassifierPrediction::from($response->json());
    }
}