<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Services\SSOService;
use App\Services\SoapAuditService;
use App\Services\RabbitMQService;

Route::middleware('apikey')->group(function () {

    Route::get('/v1/students', [StudentController::class, 'index']);

    Route::get('/v1/students/{id}', [StudentController::class, 'show']);

    Route::post('/v1/students/validate-quota',
        [StudentController::class, 'validateQuota']);

});

