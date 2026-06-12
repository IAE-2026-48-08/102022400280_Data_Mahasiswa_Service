<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SSOService
{
    public function getToken()
    {
        $response = Http::post(
            env('IAE_BASE_URL') . '/api/v1/auth/token',
            [
                'api_key' => env('IAE_API_KEY')
            ]
        );

        if ($response->successful()) {
            return $response->json()['token'];
        }

        return null;
    }
}