<?php

namespace App\Services;

use App\Events\PlantCreated;
use App\Events\PlantUpdated;
use App\Repositories\PlantRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PlantService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantRepository
     */
    protected $repository;

    public function __construct(
        PlantRepository $repository,
        public MediaService $mediaService
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $plant = $this->repository->create($data);
        event(new PlantCreated($plant->id, ['rubrics' => $data['rubrics']]));
        return $plant;
    }

    public function update($id, array $data)
    {
        $this->findOrFail($id);
        $this->repository->update($id, $data);
        event(new PlantUpdated($id, ['rubrics' => $data['rubrics']]));
        return $this->find($id);
    }

    public function findOrFailWithRubrics($id)
    {
        $plant  = $this->findOrFail($id);
        return $plant->load('rubrics.infos');
    }

    public function syncRubrics($plantId, array $rubricsData)
    {
        $plant = $this->findOrFail($plantId);

        // Supprimer toutes les rubriques existantes (et leurs infos si cascade)
        $plant->rubrics()->delete();

        // Créer toutes les rubriques nouvelles
        foreach ($rubricsData as $rubric) {
            // Créer la rubrique
            $newRubric = $plant->rubrics()->create([
                'name' => $rubric['name'],
                'description' => $rubric['description'] ?? null,
            ]);

            // Créer les infos si elles existent
            if (!empty($rubric['infos'])) {
                $infosData = [];
                foreach ($rubric['infos'] as $info) {
                    $infosData[] = [
                        'key' => $info['key'],
                        'value' => $info['value'],
                    ];
                }
                $newRubric->infos()->createMany($infosData);
            }
        }
    }

    public function anomalies(int $plantId)
    {
        $plant = $this->findOrFail($plantId);
        return $plant->anomalies;
    }

    public function uploadImage($plantId, UploadedFile $uploadedFile)
    {
        $plant = $this->findOrFail($plantId);
        return $this->mediaService->uploadFiles($plant, 'plant_images', $uploadedFile);
    }


    /**
     * Summary of uploadImages
     * @param int|string $plantId
     * @param UploadedFile[] $uploadedFiles
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media[]
     */
    public function uploadImages($plantId, array $uploadedFiles)
    {
        $plant = $this->findOrFail($plantId);
        return $this->mediaService->uploadFiles($plant, 'plant_images', $uploadedFiles);
    }
}
