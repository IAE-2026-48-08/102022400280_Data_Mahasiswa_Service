<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RabbitMQService
{
    public function publish($token, $data)
    {
        $response = Http::withToken($token)
            ->post(
                env('IAE_BASE_URL') . '/api/v1/messages/publish',
                $data
            );

        return $response->json();
    }
}