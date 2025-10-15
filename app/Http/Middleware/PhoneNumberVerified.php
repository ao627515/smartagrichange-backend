<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneNumberVerified
{

    public function __construct(
        private UserService $userService
    ) {
        //
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // est utilise pour s'assurer que le numero de telephone de l'utilisateur est verifie
        // c'est ta dire qu'il n'a pas fait verifier son otp et tente de se connecter

        $phoneNumber = $request->phone_number;
        $callingCode = $request->calling_code;
        $this->userService->ensurePhoneNumberIsVerified($phoneNumber, $callingCode);

        return $next($request);
    }
}
