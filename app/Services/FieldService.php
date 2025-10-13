<?php

namespace App\Services;

use App\Events\FieldCreated;
use App\Repositories\FieldRepository;

class FieldService extends BaseService
{
    protected $repository;

    public function __construct(FieldRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $record = $this->repository->create($data);

        event(new FieldCreated($record->id));
        return $record;
    }
}