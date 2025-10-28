<?php

namespace App\Services;

use App\Services\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PlantAnomalyRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlantAnomalyService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantAnomalyRepository
     */
    protected $repository;
    public function __construct(
        PlantAnomalyRepository $repository,
        public MediaService $mediaService

    ) {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();

        return $this->repository->create($data)->refresh();
    }

    public function uploadImage($anomalyId, UploadedFile $uploadedFile)
    {
        $anomaly = $this->findOrFail($anomalyId);
        return $this->mediaService->uploadFiles($anomaly, 'anomaly_images', $uploadedFile);
    }


    /**
     * Summary of uploadImages
     * @param int|string $anomalyId
     * @param UploadedFile[] $uploadedFiles
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media[]
     */
    public function uploadImages($anomalyId, array $uploadedFiles)
    {
        $anomaly = $this->findOrFail($anomalyId);
        return $this->mediaService->uploadFiles($anomaly, 'anomaly_images', $uploadedFiles);
    }

    public function findOrFailByNameAndPlant(int $plantId, string $name, array $columns = ['*'])
    {
        $anomaly = $this->repository->findOrFailByNameAndPlant($plantId, $name, $columns);

        if (!$anomaly) {
            throw new ModelNotFoundException("Anomaly aziz with name {$name} and plant_id {$plantId} not found");
        }

        return $anomaly;
    }
}
