<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseService
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Récupérer tous les enregistrements.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return $this->repository->all($columns);
    }


    public function allOrdered($orderBy = 'id', $direction = 'asc', $columns = ['*'])
    {
        return $this->repository->allOrdered($orderBy, $direction, $columns);
    }

    /**
     * Récupérer les enregistrements avec pagination.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Trouver un enregistrement par son ID.
     *
     * @param int $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }


    public function findOrFail($id, $columns = ['*'])
    {
        $model = $this->repository->find($id, $columns);
        if (!$model) {
            throw new ModelNotFoundException("Model with ID {$id} not found.");
        }
        return $model;
    }

    /**
     * Créer un nouvel enregistrement.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Mettre à jour un enregistrement.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data)
    {
        $this->findOrFail($id);

        $this->repository->update($id, $data);
        return $this->repository->find($id);
    }

    /**
     * Supprimer un enregistrement.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        $this->findOrFail($id);

        return $this->repository->delete($id);
    }

    /**
     * Récupérer les enregistrements selon des conditions.
     *
     * @param array $conditions
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function where(array $conditions, $columns = ['*'])
    {
        return $this->repository->where($conditions, $columns);
    }
}
