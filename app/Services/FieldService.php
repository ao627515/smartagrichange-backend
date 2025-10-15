<?php

namespace App\Services;

use Exception;
use App\Events\FieldCreated;
use Illuminate\Support\Facades\Auth;
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
        $data['user_id'] = Auth::id();
        $record = $this->repository->create($data);

        event(new FieldCreated($record->id));
        return $record;
    }

    public function update($id, array $data)
    {
        $field = $this->repository->find($id);
        if ($field->user_id !== Auth::id()) {
            throw new Exception('Unauthorized', 403);
        }
        $this->repository->update($id, $data);

        return $this->repository->find($id);
    }

    public function delete($id)
    {
        $field = $this->repository->find($id);
        if ($field->user_id !== Auth::id()) {
            throw new Exception('Unauthorized', 403);
        }
        return $this->repository->delete($id);
    }
}
