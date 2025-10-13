<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResponseResource extends JsonResource
{

    protected string $message;
    protected mixed $data;

    /**
     * Create a new instance of the resource with custom properties.
     */
    public function __construct(string $message = 'Operation successful', $data = null)
    {
        parent::__construct(null);
        $this->message = $message ?? 'Operation successful';
        $this->data = $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
