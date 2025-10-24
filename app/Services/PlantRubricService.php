<?php

namespace App\Services;

use App\Events\PlantRubricCreated;
use App\Repositories\PlantRubricRepository;
use Illuminate\Support\Facades\Auth;

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
}
