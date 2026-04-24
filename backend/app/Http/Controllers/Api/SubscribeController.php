<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscribeController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'  => 'required|email|max:150',
            'name'   => 'nullable|string|max:100',
            'source' => 'nullable|string|max:50',
        ]);

        $sub = Subscriber::firstOrCreate(
            ['email' => $data['email']],
            [
                'name'               => $data['name'] ?? null,
                'source'             => $data['source'] ?? 'web',
                'status'             => 'active',
                'confirmation_token' => Str::random(32),
                'confirmed_at'       => now(),
            ]
        );

        if ($sub->wasRecentlyCreated) {
            AdminNotification::push('subscriber.new', "Шинэ захиалагч: {$sub->email}", url('/admin/subscribers'), 'success');
        }

        return response()->json([
            'message' => 'Танд баярлалаа! Захиалга баталгаажлаа.',
            'data'    => ['email' => $sub->email],
        ], 201);
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);
        Subscriber::where('email', $data['email'])->update([
            'status'           => 'unsubscribed',
            'unsubscribed_at'  => now(),
        ]);
        return response()->json(['message' => 'Захиалгаас хасагдлаа.']);
    }
}
