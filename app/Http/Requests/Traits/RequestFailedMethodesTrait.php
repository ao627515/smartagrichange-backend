<?php

namespace App\Http\Requests\Traits;

use App\Http\Resources\ErrorResponseResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

trait RequestFailedMethodesTrait
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {

        $response = response()->json(
            data: new ErrorResponseResource(
                message: 'Validation failed.',
                errors: $validator->errors()
            ),
            status: Response::HTTP_UNPROCESSABLE_ENTITY
        );

        throw new ValidationException($validator, $response);
    }

    /**
     * Gère l'échec de l'autorisation.
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedAuthorization()
    {
        // throw new HttpResponseException(
        //     response()->json(
        //         new ErrorResponseResource(
        //             'Vous n\'êtes pas autorisé à effectuer cette action.'
        //         ),
        //         Response::HTTP_FORBIDDEN
        //     ),
        // );

        throw new \Exception(
            'Vous n\'êtes pas autorisé à effectuer cette action.',
            RESPONSE::HTTP_FORBIDDEN
        );
    }
}
