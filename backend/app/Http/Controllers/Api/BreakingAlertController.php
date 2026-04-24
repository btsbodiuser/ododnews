<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BreakingAlert;
use Illuminate\Http\JsonResponse;

class BreakingAlertController extends Controller
{
    public function index(): JsonResponse
    {
        $alerts = BreakingAlert::active()
            ->orderByRaw("FIELD(priority,'urgent','high','medium','low')")
            ->latest()
            ->take(5)
            ->get(['id', 'headline', 'message', 'url', 'priority', 'article_id']);

        return response()->json(['data' => $alerts]);
    }
}
