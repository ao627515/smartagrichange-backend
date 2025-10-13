<?php

return [
    'otp_length' => env('OTP_LENGTH', 6),
    'otp_expiry' => env('OTP_EXPIRY', 5), // in minutes
    'max_attempts' => env('OTP_MAX_ATTEMPTS', 3),
    'resend_interval' => env('OTP_RESEND_INTERVAL', 1),
    'sender_id' => env('OTP_SENDER_ID', 'SMARTAGRI'),
    'sms_provider' => env('SMS_PROVIDER', 'aquilas'),
    'default_country_calling_code' => env('DEFAULT_COUNTRY_CALLING_CODE', '+226'),
    'message_template' => env('OTP_MESSAGE_TEMPLATE', 'Your OTP code is: {otp}'),
];