<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Events\OtpVerifed;
use App\DTO\Req\Aquilas\AquilasSendSmsRequestDto;
use App\DTO\Responses\Aquilas\AquilasSendSmsSuccessResponseDto;

class OtpService
{
    private AqilasService $aquilasService;
    private UserOtpService $userOtpService;
    private UserService $userService;
    private int $otpLength;
    private int $otpExpiry;
    private int $maxAttempts;
    private int $resendInterval;

    public function __construct(
        AqilasService $aquilasService,
        UserOtpService $userOtpService,
        UserService $userService
    ) {
        $this->aquilasService = $aquilasService;
        $this->userOtpService = $userOtpService;
        $this->userService = $userService;
        $this->otpLength = config('otp.otp_length', 6);
        $this->otpExpiry = config('otp.otp_expiry', 5);
        $this->maxAttempts = config('otp.max_attempts', 3);
        $this->resendInterval = config('otp.resend_interval', 1);
    }

    public function generateOtp()
    {
        return $otp = str_pad(random_int(0, 999999), $this->otpLength, '0', STR_PAD_LEFT);
    }

    public function sendOtp($data)
    {
        if (env('MODE_DEMO', false)) {
            return;
        }
        return $this->aquilasService->sendSms($data);
    }

    public function resendOtp($userId)
    {
        //  Vérifie que l'utilisateur existe dans la base de données.
        // Si l'utilisateur n'existe pas, une exception "ModelNotFoundException" sera levée.
        $this->userService->findOrFail($userId);

        // Récupère le dernier OTP généré pour cet utilisateur.
        $lastOtp = $this->userOtpService->getLatestOtpForUser($userId);


        // Vérifie si le dernier OTP est encore valide (non expiré)
        if ($lastOtp && !$lastOtp->is_expired) {

            $now = $lastOtp->created_at->getTimestamp();
            // Calcule le temps écoulé (en secondes) depuis la création du dernier OTP.
            $timeSinceLastOtp = now()->getTimestamp() - $lastOtp->created_at->getTimestamp();

            // Convertit l’intervalle de réenvoi autorisé (en minutes) en secondes.
            // Par exemple, si resendInterval = 2, alors délai minimal = 120 secondes.
            if ($timeSinceLastOtp < $this->resendInterval * 60) {

                // emps restant avant de pouvoir redemander un nouvel OTP.
                $secondsLeft = $this->resendInterval * 60 - $timeSinceLastOtp;

                // Formate un message clair selon que le temps restant soit en secondes ou minutes.
                if ($secondsLeft < 60) {
                    $message = "Please wait {$secondsLeft} second" . ($secondsLeft > 1 ? 's' : '') . " before requesting a new OTP";
                } else {
                    $minutesLeft = ceil($secondsLeft / 60);
                    $message = "Please wait {$minutesLeft} minute" . ($minutesLeft > 1 ? 's' : '') . " before requesting a new OTP";
                }

                // Empêche le réenvoi avant la fin du délai minimal.
                // Une exception est levée, ce qui stoppe le processus.
                throw new Exception($message);
            }
        }

        // Si l’utilisateur est éligible au réenvoi (dernier OTP expiré ou utilisé),
        // on génère et envoie un nouveau code OTP via handleOtp().
        return $this->handleOtp($userId);
    }


    public function handleOtp($userId)
    {
        $user = $this->userService->findOrFail($userId);

        $otp = $this->generateOtp();

        $req = AquilasSendSmsRequestDto::from([
            'to' => [$user->full_phone_number],
        ]);
        $req->text = $req->getOtp($otp);


        $metaRaw = $this->sendOtp($req);


        $meta = $metaRaw ? json_encode($metaRaw->toArray()) : null;


        $this->userOtpService->create([
            'user_id' => $user->id,
            'otp_code' => $otp,
            'meta' => $meta,
        ]);

        return $metaRaw;
    }

    public function verifyOtp($userId, string $otp): bool
    {
        $user = $this->userService->findOrFail($userId);

        if ($user->phone_number_verified_at) {
            throw new Exception('User phone number is already verified');
        }

        $userOtp = $this->userOtpService->getLatestOtpForUser($userId);

        if (!$userOtp) {
            return false;
        }

        if (!env('MODE_DEMO', false)) {
            if ($userOtp->is_expired) {
                throw new Exception('OTP has expired');
            }

            if ($userOtp->attempts >= $this->maxAttempts) {
                throw new Exception('Maximum OTP verification attempts exceeded');
            }

            if ($userOtp->otp_code !== $otp) {
                $this->userOtpService->incrementAttempts($userOtp->id);
                throw new Exception('Invalid OTP');
            }

            if ($userOtp->is_used) {
                throw new Exception('OTP has already been used');
            }
        }


        $this->userOtpService->markAsUsed($userOtp->id);
        event(new OtpVerifed($userId));
        return true;
    }
}
