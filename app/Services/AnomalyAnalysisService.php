<?php

namespace App\Services;

use App\Events\AnomalyAnalysisCreated;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AnomalyAnalysisRepository;

class AnomalyAnalysisService extends BaseService
{
    /**
     * Summary of repository
     * @var AnomalyAnalysisRepository
     */
    protected $repository;

    public function __construct(AnomalyAnalysisRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function createwithSingleImg(array $data)
    {
        $data = array_merge(
            $data,
            [
                'user_id' => Auth::id()
            ]
        );

        $record = $this->repository->createWithAnalysis($data);

        // event(new AnomalyAnalysisCreated($record->id, ['img' => $data['image']]));

        return $record->refresh()->load('analysis');
    }
}
