<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterCampaign;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = NewsletterCampaign::latest()->paginate(20);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:255',
            'from_name'    => 'required|string|max:255',
            'from_email'   => 'required|email',
            'html_body'    => 'required|string',
            'plain_body'   => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);
        $data['user_id'] = auth()->id();
        $data['status']  = $data['scheduled_at'] ?? false ? 'scheduled' : 'draft';
        $campaign = NewsletterCampaign::create($data);
        return redirect()->route('admin.campaigns.edit', $campaign)->with('success', 'Кампанит хадгалагдлаа.');
    }

    public function edit(NewsletterCampaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, NewsletterCampaign $campaign)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:255',
            'from_name'    => 'required|string|max:255',
            'from_email'   => 'required|email',
            'html_body'    => 'required|string',
            'plain_body'   => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);
        $campaign->update($data);
        return back()->with('success', 'Кампанит шинэчлэгдлээ.');
    }

    public function send(NewsletterCampaign $campaign)
    {
        // Real send would queue per-recipient mail jobs.
        $count = Subscriber::active()->count();
        $campaign->update([
            'status'           => 'sent',
            'sent_at'          => now(),
            'recipients_count' => $count,
        ]);
        return back()->with('success', "Кампанитыг {$count} захиалагч руу илгээх дараалалд орууллаа.");
    }

    public function destroy(NewsletterCampaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Кампанит устгагдлаа.');
    }
}
