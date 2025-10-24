<?php

namespace App\Services;

use App\Events\PlantCreated;
use App\Repositories\PlantRepository;
use Illuminate\Support\Facades\Auth;

class PlantService extends BaseService
{
    /**
     * Summary of repository
     * @var PlantRepository
     */
    protected $repository;

    public function __construct(PlantRepository $repository)
    {
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
}
