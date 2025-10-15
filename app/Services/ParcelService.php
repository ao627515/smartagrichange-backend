<?php

namespace App\Services;

use App\Repositories\ParcelRepository;

class ParcelService extends BaseService
{
    protected $repository;

    public function __construct(
        ParcelRepository $repository,
        private FieldService $fieldService
    ) {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function createForField(int $fieldId)
    {
        $this->create([
            'name' => 'Default Parcel',
            'area' => 0,
            'field_id' => $fieldId,
        ]);
    }
}
