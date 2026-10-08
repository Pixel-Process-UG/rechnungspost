<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Integration;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class IntegrationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Integration::all());
    }
}
