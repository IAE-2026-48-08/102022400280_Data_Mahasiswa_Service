<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Student Service API",
    description: "API untuk data mahasiswa dan validasi kuota"
)]

#[OA\SecurityScheme(
    securityScheme: "ApiKeyAuth",
    type: "apiKey",
    in: "header",
    name: "X-API-KEY"
)]

final class ApiInfo
{
}