<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Article;
use App\Models\BreakingAlert;
use Illuminate\Http\Request;

class BreakingAlertController extends Controller
{
    public function index()
    {
        $alerts = BreakingAlert::with('article', 'user')->latest()->paginate(20);
        return view('admin.breaking.index', compact('alerts'));
    }

    public function create()
    {
        $articles = Article::published()->latest()->take(50)->get();
        return view('admin.breaking.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'article_id' => 'nullable|exists:articles,id',
            'headline'   => 'required|string|max:255',
            'message'    => 'nullable|string',
            'url'        => 'nullable|url',
            'priority'   => 'required|in:low,medium,high,urgent',
            'status'     => 'required|in:draft,active,expired',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);
        $data['user_id'] = auth()->id();
        $alert = BreakingAlert::create($data);

        if ($alert->status === 'draft') {
            AdminNotification::notify(
                'breaking.draft',
                "Шинэ яаралтай мэдээний ноорог: {$alert->headline}",
                route('admin.breaking.edit', $alert),
                'warning'
            );
        }
        return redirect()->route('admin.breaking.index')->with('success', 'Яаралтай мэдээ үүслээ.');
    }

    public function edit(BreakingAlert $breaking)
    {
        $articles = Article::published()->latest()->take(50)->get();
        return view('admin.breaking.edit', ['alert' => $breaking, 'articles' => $articles]);
    }

    public function update(Request $request, BreakingAlert $breaking)
    {
        $data = $request->validate([
            'article_id' => 'nullable|exists:articles,id',
            'headline'   => 'required|string|max:255',
            'message'    => 'nullable|string',
            'url'        => 'nullable|url',
            'priority'   => 'required|in:low,medium,high,urgent',
            'status'     => 'required|in:draft,active,expired',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);
        $breaking->update($data);
        return back()->with('success', 'Яаралтай мэдээ шинэчлэгдлээ.');
    }

    public function push(BreakingAlert $breaking)
    {
        // Real impl: dispatch job to FCM/SMS gateway.
        $breaking->update(['push_sent' => true, 'status' => 'active']);
        return back()->with('success', 'Push мэдэгдэл илгээгдлээ.');
    }

    public function destroy(BreakingAlert $breaking)
    {
        $breaking->delete();
        return back()->with('success', 'Яаралтай мэдээ устгагдлаа.');
    }
}
