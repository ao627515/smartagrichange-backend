<?php

namespace App\Http\Controllers;

use App\Http\Requests\Field\FieldStoreRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FieldStoreRequest $request)
    {
        $data = $request->validated();
        $field = $this->fieldService->create($data);

        return new SuccessResponseResource(
            'Field created successfully',
            new FieldResource($field)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        //
    }
}
