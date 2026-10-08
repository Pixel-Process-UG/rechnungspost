<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ForwardingRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ForwardingRuleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ForwardingRule::all());
    }
}
