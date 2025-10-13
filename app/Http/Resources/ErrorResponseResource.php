<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponseResource extends JsonResource
{
    protected string $message;
    protected mixed $errors;

    /**
     * Create a new instance of the resource with custom properties.
     */
    public function __construct(string $message = 'Operation failed', $errors = null)
    {
        parent::__construct(null);
        $this->message = $message;
        $this->errors = $errors;
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
            'errors' => $this->errors,
        ];
    }
}
