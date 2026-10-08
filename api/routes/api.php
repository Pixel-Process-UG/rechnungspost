<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('invoices', \App\Http\Controllers\Api\V1\InvoiceController::class);
    Route::apiResource('integrations', \App\Http\Controllers\Api\V1\IntegrationController::class);
    Route::apiResource('forwarding-rules', \App\Http\Controllers\Api\V1\ForwardingRuleController::class);
});

Route::post('/auth/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
     ->name('login');
