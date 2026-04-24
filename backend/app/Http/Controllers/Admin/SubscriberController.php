<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%");
            });
        }
        $subscribers = $query->latest()->paginate(30)->withQueryString();

        $totals = [
            'all'          => Subscriber::count(),
            'active'       => Subscriber::where('status', 'active')->count(),
            'unsubscribed' => Subscriber::where('status', 'unsubscribed')->count(),
            'pending'      => Subscriber::where('status', 'pending')->count(),
        ];

        return view('admin.subscribers.index', compact('subscribers', 'totals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name'  => 'nullable|string|max:255',
        ]);
        Subscriber::create($data + ['status' => 'active', 'source' => 'admin']);
        return back()->with('success', 'Захиалагч нэмэгдлээ.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Захиалагч устгагдлаа.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'subscribers_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Email', 'Name', 'Status', 'Source', 'Subscribed At']);
            Subscriber::orderBy('id')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [$r->email, $r->name, $r->status, $r->source, $r->created_at]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
