<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function show(string $slotCode): JsonResponse
    {
        $slot = AdSlot::where('code', $slotCode)->where('is_active', true)->first();
        if (! $slot) return response()->json(['data' => null]);

        $ad = Ad::active()->where('slot_id', $slot->id)->inRandomOrder()->first();
        if (! $ad) return response()->json(['data' => null]);

        $ad->increment('impressions');

        return response()->json([
            'data' => [
                'id'         => $ad->id,
                'type'       => $ad->type,
                'name'       => $ad->name,
                'image_url'  => $ad->image_path ? asset('storage/' . $ad->image_path) : null,
                'html_code'  => $ad->html_code,
                'target_url' => $ad->target_url ? route('api.ads.click', $ad) : null,
                'size'       => $slot->size,
            ],
        ]);
    }

    public function click(Request $request, Ad $ad)
    {
        $ad->increment('clicks');
        return redirect()->away($ad->target_url ?? '/');
    }
}
