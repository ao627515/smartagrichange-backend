<?php

namespace App\Services;

use App\Events\PlantRubricCreated;
use App\Events\PlantRubricUpdated;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PlantRubricRepository;

class PlantRubricService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantRubricRepository
     */
    protected $repository;

    public function __construct(PlantRubricRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {

        $data['user_id'] = Auth::id();
        $rubric = $this->repository->create($data);
        event(new PlantRubricCreated($rubric->id, ['infos' => $data['infos']]));
        return $rubric;
    }

    public function update($id, array $data)
    {
        $this->findOrFail($id);
        $this->repository->update($id, $data);
        event(new PlantRubricUpdated($id, ['infos' => $data['infos']]));
        return $this->find($id);
    }
}
