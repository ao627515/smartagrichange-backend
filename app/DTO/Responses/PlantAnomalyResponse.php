<?php

namespace App\DTO\Responses;

use Spatie\LaravelData\Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PlantAnomalyResponse extends Data
{
    public int $id;
    public string $name;
    public string $description;
    public string $symptoms;
    public string $solutions;
    public string $preventions;
    public string $causes;
    public string $category;
    public ?int $user_id;
    public int $plant_id;
    public array $images = [];
    public ?string $created_at;

    /**
     * Constructeur pour initialiser tous les champs.
     */
    public function __construct(
        int $id,
        string $name,
        string $description,
        string $symptoms,
        string $solutions,
        string $preventions,
        string $causes,
        string $category,
        ?int $user_id,
        int $plant_id,
        array $images = [],
        ?string $created_at = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->symptoms = $symptoms;
        $this->solutions = $solutions;
        $this->preventions = $preventions;
        $this->causes = $causes;
        $this->category = $category;
        $this->user_id = $user_id;
        $this->plant_id = $plant_id;
        $this->images = $images;
        $this->created_at = $created_at;
    }

    /**
     * Transforme un modèle Anomaly en PlantAnomalyResponse.
     */
    public static function fromModel(\App\Models\Anomaly $model): self
    {
        // Eager load de la relation media pour éviter le N+1
        // $model->load('media');

        // Récupération des URLs des médias liés
        $images = $model->getMedia('anomaly_images')
            ->map(fn(Media $media) => $media->getFullUrl())
            ->toArray();

        return new self(
            $model->id,
            $model->name,
            $model->description,
            $model->symptoms,
            $model->solutions,
            $model->preventions,
            $model->causes,
            $model->category,
            $model->user_id,
            $model->plant_id,
            $images,
            $model->created_at,
        );
    }
}
