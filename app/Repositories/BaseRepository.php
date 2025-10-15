<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Récupère tous les enregistrements.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function allOrdered($orderBy = 'id', $direction = 'asc', $columns = ['*'])
    {
        return $this->model->orderBy($orderBy, $direction)->get($columns);
    }

    /**
     * Récupère tous les enregistrements avec pagination.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Trouve un enregistrement par son ID.
     *
     * @param int $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }


    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * Crée un nouvel enregistrement.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Met à jour un enregistrement par son ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    /**
     * Supprime un enregistrement par son ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    /**
     * Récupère les enregistrements selon des conditions.
     *
     * @param array $conditions
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function where(array $conditions, $columns = ['*'])
    {
        $query = $this->model->query();
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        return $query->get($columns);
    }

    public function whereFirst(array $conditions, $columns = ['*'])
    {
        $query = $this->model->query();
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        return $query->first($columns);
    }

    public function attach($id, $relation, $relatedId)
    {
        $record = $this->find($id);
        if ($record && method_exists($record, $relation)) {
            return $record->$relation()->attach($relatedId);
        }
        return false;
    }

    public function detach($id, $relation, $relatedId)
    {
        $record = $this->find($id);
        if ($record && method_exists($record, $relation)) {
            return $record->$relation()->detach($relatedId);
        }
        return false;
    }

    public function sync($id, $relation, $relatedIds)
    {
        $record = $this->find($id);
        if ($record && method_exists($record, $relation)) {
            return $record->$relation()->sync($relatedIds);
        }
        return false;
    }
}
