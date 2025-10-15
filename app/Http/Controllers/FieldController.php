<?php

namespace App\Http\Controllers;

use App\Http\Requests\Field\FieldStoreRequest;
use App\Http\Requests\Field\FieldUpdateRequest;
use App\Http\Resources\Field\FieldResource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Field;
use App\Services\FieldService;
use Illuminate\Http\Request;

class FieldController extends Controller
{

    public function __construct(
        private FieldService $fieldService

    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = $this->fieldService->allOrdered('created_at', 'desc');
        return new SuccessResponseResource(
            'Fields retrieved successfully',
            FieldResource::collection($fields)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FieldStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $field = $this->fieldService->create($data);

        return new SuccessResponseResource(
            'Field created successfully',
            new FieldResource($field)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($field)
    {
        $field = $this->fieldService->find($field);
        return new FieldResource($field);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FieldUpdateRequest $request, $field)
    {
        $data = $request->validated();
        $field = $this->fieldService->update($field, $data);
        return new SuccessResponseResource(
            'Field updated successfully',
            new FieldResource($field)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $this->fieldService->delete($field->id);
        return new SuccessResponseResource(
            'Field deleted successfully'
        );
    }
}
